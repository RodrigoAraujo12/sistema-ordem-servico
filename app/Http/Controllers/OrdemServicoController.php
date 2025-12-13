<?php

namespace App\Http\Controllers;

use App\Models\OrdemServico;
use App\Models\Cliente;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class OrdemServicoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        Log::info('ORDENSSERVICO INDEX', [
            'auth_check' => auth()->check(),
            'user_id' => auth()->id(),
            'session_id' => request()->session()->getId(),
            'has_cookie' => request()->hasCookie(config('session.cookie')),
        ]);
        
        $query = OrdemServico::query()->with(['cliente', 'tecnico'])->orderByDesc('created_at');

        // Técnico só vê suas ordens
        if (auth()->user()->isTecnico()) {
            $query->where('tecnico_id', auth()->id());
        }

        // Filtrar por busca
        if (request('search')) {
            $search = request('search');
            $query->where('numero_ordem', 'like', "%{$search}%")
                ->orWhereHas('cliente', function ($q) use ($search) {
                    $q->where('nome', 'like', "%{$search}%");
                });
        }

        // Filtrar por status
        if (request('status')) {
            $query->where('status', request('status'));
        }

        $ordensServico = $query->paginate(10);

        return view('ordensservico.index', compact('ordensServico'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        return view('ordensservico.create', compact('clientes'));
    }

    public function show(OrdemServico $ordem)
    {
        // Técnico só pode ver suas próprias ordens
        if (auth()->user()->isTecnico() && $ordem->tecnico_id !== auth()->id()) {
            abort(403, 'Você não tem permissão para visualizar esta ordem.');
        }

        $ordem->load(['cliente', 'tecnico']);
        return view('ordensservico.show', ['ordem' => $ordem]);
    }

    public function edit(OrdemServico $ordem)
    {
        // Técnico só pode editar suas próprias ordens
        if (auth()->user()->isTecnico() && $ordem->tecnico_id !== auth()->id()) {
            abort(403, 'Você não tem permissão para editar esta ordem.');
        }

        $ordem->load(['cliente', 'tecnico']);
        $tecnicos = \App\Models\User::where('role', 'tecnico')->get();
        return view('ordensservico.edit', compact('ordem', 'tecnicos'));
    }

    public function store()
    {
        // Validar dados
        $validated = request()->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'aparelho' => 'required|string|max:100',
            'defeito_relatado' => 'required|string',
            'orcamento' => 'nullable|numeric|min:0',
            'valor_aprovado' => 'nullable|numeric|min:0',
            'observacoes' => 'nullable|string',
        ]);

        // Gerar número único da ordem
        $count = OrdemServico::count() + 1;
        $numeroOrdem = 'OS-' . Carbon::now()->format('Ymd') . str_pad($count, 4, '0', STR_PAD_LEFT);

        // Criar a ordem
        $ordem = OrdemServico::create([
            'cliente_id' => $validated['cliente_id'],
            'numero_ordem' => $numeroOrdem,
            'aparelho' => $validated['aparelho'],
            'defeito_relatado' => $validated['defeito_relatado'],
            'orcamento' => $validated['orcamento'] ?? 0,
            'valor_aprovado' => $validated['valor_aprovado'] ?? 0,
            'data_entrada' => now(),
            'status' => 'analise',
            'observacoes' => $validated['observacoes'] ?? '',
        ]);

        // Gerar token público para acesso do cliente
        $ordem->generatePublicToken();

        return redirect()->route('ordensservico.index')->with('success', 'Ordem de serviço criada com sucesso!');
    }

    public function update(OrdemServico $ordem)
    {
        // Validar dados
        $validated = request()->validate([
            'aparelho' => 'required|string|max:100',
            'defeito_relatado' => 'required|string',
            'status' => 'required|in:analise,aguardando_peca,em_reparo,concluido,entregue,cancelado',
            'orcamento' => 'nullable|numeric|min:0',
            'valor_aprovado' => 'nullable|numeric|min:0',
            'observacoes' => 'nullable|string',
            'tecnico_id' => 'nullable|exists:users,id',
        ]);

        // Detectar mudança de status para enviar notificação
        $statusAntigo = $ordem->status;
        $statusNovo = $validated['status'];
        $statusMudou = $statusAntigo !== $statusNovo;

        // Registrar mudanças no histórico
        $campos = [
            'status' => 'Status',
            'aparelho' => 'Aparelho',
            'defeito_relatado' => 'Defeito Relatado',
            'orcamento' => 'Orçamento',
            'valor_aprovado' => 'Valor Aprovado',
            'observacoes' => 'Observações',
            'tecnico_id' => 'Técnico',
        ];

        foreach ($campos as $campo => $label) {
            $valorNovo = $validated[$campo] ?? null;
            $valorAntigo = $ordem->$campo;

            if ($valorNovo != $valorAntigo) {
                // Formatar valores para exibição
                if ($campo === 'status') {
                    $valorAntigoFormatado = \App\Models\OrdemServico::STATUS[$valorAntigo] ?? $valorAntigo;
                    $valorNovoFormatado = \App\Models\OrdemServico::STATUS[$valorNovo] ?? $valorNovo;
                } elseif ($campo === 'tecnico_id') {
                    $valorAntigoFormatado = $valorAntigo ? \App\Models\User::find($valorAntigo)?->name : 'Nenhum';
                    $valorNovoFormatado = $valorNovo ? \App\Models\User::find($valorNovo)?->name : 'Nenhum';
                } elseif (in_array($campo, ['orcamento', 'valor_aprovado'])) {
                    $valorAntigoFormatado = 'R$ ' . number_format($valorAntigo ?? 0, 2, ',', '.');
                    $valorNovoFormatado = 'R$ ' . number_format($valorNovo ?? 0, 2, ',', '.');
                } else {
                    $valorAntigoFormatado = $valorAntigo ?: 'Vazio';
                    $valorNovoFormatado = $valorNovo ?: 'Vazio';
                }

                \App\Models\OrdemHistorico::create([
                    'ordem_servico_id' => $ordem->id,
                    'user_id' => auth()->id(),
                    'campo_alterado' => $label,
                    'valor_anterior' => $valorAntigoFormatado,
                    'valor_novo' => $valorNovoFormatado,
                    'descricao' => "{$label} alterado de \"{$valorAntigoFormatado}\" para \"{$valorNovoFormatado}\"",
                ]);
            }
        }

        // Atualizar a ordem
        $dados = [
            'aparelho' => $validated['aparelho'],
            'defeito_relatado' => $validated['defeito_relatado'],
            'status' => $validated['status'],
            'orcamento' => $validated['orcamento'] ?? 0,
            'valor_aprovado' => $validated['valor_aprovado'] ?? 0,
            'observacoes' => $validated['observacoes'] ?? '',
            'tecnico_id' => $validated['tecnico_id'] ?? null,
        ];

        // Se mudar para concluido ou entregue, registrar data_saida
        if (in_array($validated['status'], ['concluido', 'entregue']) && !$ordem->data_saida) {
            $dados['data_saida'] = now();
        }

        $ordem->update($dados);

        // Enviar notificação por email se o status mudou
        if ($statusMudou && $ordem->cliente && $ordem->cliente->email) {
            try {
                $ordem->cliente->notify(new \App\Notifications\OrdemStatusAlterada($ordem, $statusAntigo, $statusNovo));
            } catch (\Exception $e) {
                // Log do erro mas não falha a operação
                Log::warning('Falha ao enviar notificação de email: ' . $e->getMessage());
            }
        }

        return redirect()->route('ordensservico.show', $ordem)->with('success', 'Ordem de serviço atualizada com sucesso!');
    }

    public function destroy(OrdemServico $ordem)
    {
        $ordem->delete();
        return redirect()->route('ordensservico.index');
    }
}
