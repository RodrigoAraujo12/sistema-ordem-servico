<?php

namespace App\Http\Controllers;

use App\Models\Pagamento;
use App\Models\OrdemServico;
use Illuminate\Http\RedirectResponse;

class PagamentoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function store(): RedirectResponse
    {
        $data = request()->validate([
            'ordem_id' => 'required|exists:ordensservico,id',
            'valor' => 'required|numeric|min:0.01',
            'metodo' => 'required|in:pix,cartao,dinheiro,boleto',
            'data_pagamento' => 'required|date',
            'observacao' => 'nullable|string|max:1000',
        ]);

        $ordem = OrdemServico::findOrFail($data['ordem_id']);

        // Regra: não permitir pagamento acima do saldo a receber
        $saldo = $ordem->saldo_receber;
        if ($data['valor'] > $saldo + 0.001) {
            return back()->withErrors(['valor' => 'Valor excede o saldo a receber (R$ ' . number_format($saldo, 2, ',', '.') . ').'])->withInput();
        }

        Pagamento::create([
            'ordem_servico_id' => $ordem->id,
            'valor' => $data['valor'],
            'metodo' => $data['metodo'],
            'data_pagamento' => $data['data_pagamento'],
            'observacao' => $data['observacao'] ?? null,
        ]);

        return back()->with('success', 'Pagamento registrado com sucesso.');
    }

    public function destroy(Pagamento $pagamento): RedirectResponse
    {
        $pagamento->delete();
        return back()->with('success', 'Pagamento excluído com sucesso.');
    }
}
