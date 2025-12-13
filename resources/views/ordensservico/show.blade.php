@extends('layouts.app')

@section('title', 'Detalhes da Ordem')

@section('content')
<div class="py-6">
    <div class="mb-4">
        <a href="{{ route('ordensservico.index') }}" class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-brand-accent to-brand-border-strong text-white rounded-lg hover:shadow-lg hover:scale-105 transition-all duration-200 font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Voltar para Ordens
        </a>
    </div>
    @if(!$ordem)
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            <p>Ordem de serviço não encontrada!</p>
            <a href="{{ route('ordensservico.index') }}" class="text-red-600 underline">Voltar</a>
        </div>
    @else
    <div class="glass-card rounded-2xl p-6">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">{{ $ordem->numero_ordem ?? 'Sem número' }}</h2>
                <p class="text-gray-600 text-sm">Cliente: {{ $ordem->cliente->nome ?? 'Sem cliente' }}</p>
            </div>
            <div class="flex gap-2">
                @if(Auth::user()->isAdmin() || $ordem->tecnico_id === Auth::id())
                <a href="{{ route('ordensservico.edit', $ordem) }}" class="px-4 py-2 bg-brand-accent text-white rounded-lg hover:bg-brand-accent-soft transition-colors shadow-md">Editar</a>
                @endif
                <a href="{{ route('pdf.gerar', $ordem) }}" class="px-4 py-2 bg-brand-border-strong text-white rounded-lg hover:bg-brand-accent-soft transition-colors shadow-md">Baixar PDF</a>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-6">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informações Gerais</h3>
                <dl class="space-y-2">
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Aparelho</dt>
                        <dd class="text-sm text-gray-900">{{ $ordem->aparelho }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Defeito Relatado</dt>
                        <dd class="text-sm text-gray-900">{{ $ordem->defeito_relatado }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Status</dt>
                        <dd class="text-sm">
                            <span class="px-3 py-1 rounded-full text-white text-xs font-medium
                                @if($ordem->status === 'concluido' || $ordem->status === 'entregue') bg-green-500
                                @elseif($ordem->status === 'cancelado') bg-red-500
                                @elseif($ordem->status === 'em_reparo') bg-yellow-500
                                @else bg-blue-500 @endif">
                                {{ $ordem->status_formatado }}
                            </span>
                        </dd>
                    </div>
                </dl>
            </div>

            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Valores</h3>
                <dl class="space-y-2">
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Orçamento</dt>
                        <dd class="text-sm text-gray-900">R$ {{ number_format($ordem->orcamento ?? 0, 2, ',', '.') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Valor Aprovado</dt>
                        <dd class="text-sm text-gray-900">R$ {{ number_format($ordem->valor_aprovado ?? 0, 2, ',', '.') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Data de Entrada</dt>
                        <dd class="text-sm text-gray-900">{{ $ordem->data_entrada->format('d/m/Y') }}</dd>
                    </div>
                    @if($ordem->data_saida)
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Data de Saída</dt>
                        <dd class="text-sm text-gray-900">{{ $ordem->data_saida->format('d/m/Y') }}</dd>
                    </div>
                    @endif
                </dl>
            </div>
        </div>

        @if($ordem->observacoes)
        <div class="mt-6 pt-6 border-t">
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Observações</h3>
            <p class="text-sm text-gray-600">{{ $ordem->observacoes }}</p>
        </div>
        @endif
    </div>

    <!-- Seção Financeira: Pagamentos -->
    <div class="glass-card rounded-2xl p-6 mt-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-semibold text-gray-900">Financeiro</h3>
            @if(Auth::user()->isAdmin())
            <div x-data="{ open: false }" class="text-right w-full sm:w-auto">
                <button @click="open = !open" type="button" class="inline-flex items-center px-4 py-2 bg-brand-accent text-white rounded-lg hover:bg-brand-accent-soft transition-colors shadow-md">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Adicionar pagamento
                </button>
                <div x-show="open" x-cloak class="mt-4">
                    <form action="{{ route('pagamentos.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                        @csrf
                        <input type="hidden" name="ordem_id" value="{{ $ordem->id }}">
                        <div>
                            <label for="valor" class="block text-sm font-medium text-gray-700">Valor</label>
                            <input id="valor" name="valor" type="number" step="0.01" min="0" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-accent focus:ring-brand-accent" placeholder="0,00">
                        </div>
                        <div>
                            <label for="metodo" class="block text-sm font-medium text-gray-700">Método</label>
                            <select id="metodo" name="metodo" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-accent focus:ring-brand-accent">
                                <option value="pix">PIX</option>
                                <option value="cartao">Cartão</option>
                                <option value="dinheiro">Dinheiro</option>
                                <option value="boleto">Boleto</option>
                            </select>
                        </div>
                        <div>
                            <label for="data_pagamento" class="block text-sm font-medium text-gray-700">Data</label>
                            <input id="data_pagamento" name="data_pagamento" type="date" value="{{ now()->format('Y-m-d') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-accent focus:ring-brand-accent">
                        </div>
                        <div class="md:col-span-4">
                            <label for="observacao" class="block text-sm font-medium text-gray-700">Observação</label>
                            <div class="flex gap-4">
                                <textarea id="observacao" name="observacao" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-accent focus:ring-brand-accent" placeholder="Opcional"></textarea>
                                <button type="submit" class="h-10 md:h-auto self-end px-4 py-2 bg-brand-border-strong text-white rounded-lg hover:bg-brand-accent-soft transition-colors shadow-md whitespace-nowrap">Salvar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @endif
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="p-4 rounded-lg bg-white shadow-sm border">
                <div class="text-sm text-gray-600">Valor aprovado</div>
                <div class="text-2xl font-bold text-gray-900">R$ {{ number_format($ordem->valor_aprovado ?? 0, 2, ',', '.') }}</div>
            </div>
            <div class="p-4 rounded-lg bg-white shadow-sm border">
                <div class="text-sm text-gray-600">Total pago</div>
                <div class="text-2xl font-bold text-green-600">R$ {{ number_format($ordem->total_pago ?? 0, 2, ',', '.') }}</div>
            </div>
            <div class="p-4 rounded-lg bg-white shadow-sm border">
                <div class="text-sm text-gray-600">Saldo a receber</div>
                <div class="text-2xl font-bold {{ ($ordem->saldo_receber ?? 0) > 0 ? 'text-yellow-600' : 'text-gray-900' }}">R$ {{ number_format($ordem->saldo_receber ?? 0, 2, ',', '.') }}</div>
            </div>
        </div>

        <div>
            <h4 class="text-lg font-semibold text-gray-900 mb-3">Pagamentos</h4>
            @php
                $pagamentos = $ordem->pagamentos->sortByDesc('data_pagamento');
                $labelMetodo = function($m) {
                    return [
                        'pix' => 'PIX',
                        'cartao' => 'Cartão',
                        'dinheiro' => 'Dinheiro',
                        'boleto' => 'Boleto',
                    ][$m] ?? ucfirst($m);
                };
            @endphp
            @if($pagamentos->isEmpty())
                <p class="text-sm text-gray-600">Nenhum pagamento registrado.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full glass-table rounded-lg overflow-hidden">
                        <thead>
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Data</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Método</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Valor</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Observação</th>
                                @if(Auth::user()->isAdmin())
                                <th class="px-4 py-3 text-right text-xs font-medium text-white uppercase tracking-wider">Ações</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($pagamentos as $pg)
                                <tr>
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ optional($pg->data_pagamento)->format('d/m/Y') }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $labelMetodo($pg->metodo) }}</td>
                                    <td class="px-4 py-3 text-sm font-semibold text-gray-900">R$ {{ number_format($pg->valor, 2, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">{{ $pg->observacao }}</td>
                                    @if(Auth::user()->isAdmin())
                                    <td class="px-4 py-3 text-right">
                                        <form id="delete-pagamento-{{ $pg->id }}" action="{{ route('pagamentos.destroy', $pg) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="confirmDelete('Excluir Pagamento', 'Tem certeza que deseja excluir este pagamento de R$ {{ number_format($pg->valor, 2, ',', '.') }}?', 'delete-pagamento-{{ $pg->id }}')" class="px-3 py-1.5 text-sm bg-red-500 text-white rounded-md hover:bg-red-600 shadow">Excluir</button>
                                        </form>
                                    </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <!-- Seção Histórico de Mudanças -->
    <div class="glass-card rounded-2xl p-6 mt-6">
        <h3 class="text-xl font-semibold text-gray-900 mb-4">Histórico de Alterações</h3>
        @php
            $historico = $ordem->historico()->with('usuario')->orderByDesc('created_at')->get();
        @endphp
        @if($historico->isEmpty())
            <p class="text-sm text-gray-600">Nenhuma alteração registrada.</p>
        @else
            <div class="space-y-4">
                @foreach($historico as $h)
                    <div class="flex gap-4 p-4 bg-white rounded-lg border border-gray-200 hover:shadow-md transition-shadow">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 rounded-full bg-brand-accent bg-opacity-10 flex items-center justify-center">
                                <svg class="w-5 h-5 text-brand-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">{{ $h->campo_alterado }}</p>
                                    <p class="text-sm text-gray-600 mt-1">
                                        <span class="text-red-600">{{ $h->valor_anterior }}</span> 
                                        <svg class="w-4 h-4 inline mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                        </svg>
                                        <span class="text-green-600">{{ $h->valor_novo }}</span>
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-gray-500">{{ $h->usuario->name ?? 'Sistema' }}</p>
                                    <p class="text-xs text-gray-400">{{ $h->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
    @endif
</div>
@endsection
