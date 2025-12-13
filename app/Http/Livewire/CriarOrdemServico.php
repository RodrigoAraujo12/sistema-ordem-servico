<?php

namespace App\Http\Livewire;

use App\Models\Cliente;
use App\Models\OrdemServico;
use Livewire\Component;
use Carbon\Carbon;

class CriarOrdemServico extends Component
{
    public $cliente_id = '';
    public $aparelho = '';
    public $defeito_relatado = '';
    public $orcamento = '';
    public $valor_aprovado = '';
    public $observacoes = '';

    protected $rules = [
        'cliente_id' => 'required|exists:clientes,id',
        'aparelho' => 'required|string|max:100',
        'defeito_relatado' => 'required|string',
        'orcamento' => 'nullable|numeric|min:0',
        'valor_aprovado' => 'nullable|numeric|min:0',
        'observacoes' => 'nullable|string',
    ];

    public function save()
    {
        $this->validate();

        $numeroOrdem = 'OS-' . Carbon::now()->format('Ymd') . str_pad(OrdemServico::count() + 1, 4, '0', STR_PAD_LEFT);

        OrdemServico::create([
            'cliente_id' => $this->cliente_id,
            'numero_ordem' => $numeroOrdem,
            'aparelho' => $this->aparelho,
            'defeito_relatado' => $this->defeito_relatado,
            'orcamento' => $this->orcamento,
            'valor_aprovado' => $this->valor_aprovado,
            'data_entrada' => now(),
            'observacoes' => $this->observacoes,
        ]);

        session()->flash('success', 'Ordem de serviço criada com sucesso!');
        $this->reset();
    }

    public function render()
    {
        return view('livewire.criar-ordem-servico', [
            'clientes' => Cliente::all(),
        ]);
    }
}
