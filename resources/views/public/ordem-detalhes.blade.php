<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ordem de Serviço - {{ $ordem->numero_ordem }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'brand-accent': '#4F46E5',
                        'brand-accent-soft': '#312E81',
                        'brand-border-strong': '#4C1D95',
                    }
                }
            }
        }
    </script>
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }
    </style>
</head>
<body class="py-8 px-4">
    <div class="max-w-4xl mx-auto">
        <!-- Cabeçalho -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-white rounded-full shadow-lg mb-4">
                <svg class="w-8 h-8 text-brand-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-white mb-2">Assistência Técnica</h1>
            <p class="text-white text-opacity-90">Acompanhe sua ordem de serviço</p>
        </div>

        <!-- Card Principal -->
        <div class="glass-card rounded-2xl p-8 mb-6">
            <div class="border-b border-gray-200 pb-6 mb-6">
                <div class="flex items-start justify-between">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900">{{ $ordem->numero_ordem }}</h2>
                        <p class="text-gray-600 mt-1">Cliente: {{ $ordem->cliente->nome }}</p>
                    </div>
                    <div>
                        <span class="px-4 py-2 rounded-full text-white text-sm font-medium
                            @if($ordem->status === 'concluido' || $ordem->status === 'entregue') bg-green-500
                            @elseif($ordem->status === 'cancelado') bg-red-500
                            @elseif($ordem->status === 'em_reparo') bg-yellow-500
                            @else bg-blue-500 @endif">
                            {{ $ordem->status_formatado }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Informações do Serviço -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informações do Serviço</h3>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-600">Aparelho</dt>
                            <dd class="text-sm text-gray-900 mt-1">{{ $ordem->aparelho }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-600">Defeito Relatado</dt>
                            <dd class="text-sm text-gray-900 mt-1">{{ $ordem->defeito_relatado }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-600">Data de Entrada</dt>
                            <dd class="text-sm text-gray-900 mt-1">{{ $ordem->data_entrada->format('d/m/Y') }}</dd>
                        </div>
                        @if($ordem->data_saida)
                        <div>
                            <dt class="text-sm font-medium text-gray-600">Data de Conclusão</dt>
                            <dd class="text-sm text-gray-900 mt-1">{{ $ordem->data_saida->format('d/m/Y') }}</dd>
                        </div>
                        @endif
                    </dl>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Valores</h3>
                    <dl class="space-y-3">
                        @if($ordem->orcamento > 0)
                        <div>
                            <dt class="text-sm font-medium text-gray-600">Orçamento</dt>
                            <dd class="text-sm text-gray-900 mt-1">R$ {{ number_format($ordem->orcamento, 2, ',', '.') }}</dd>
                        </div>
                        @endif
                        @if($ordem->valor_aprovado > 0)
                        <div>
                            <dt class="text-sm font-medium text-gray-600">Valor do Serviço</dt>
                            <dd class="text-lg font-bold text-gray-900 mt-1">R$ {{ number_format($ordem->valor_aprovado, 2, ',', '.') }}</dd>
                        </div>
                        @endif
                        @if($ordem->pagamentos->isNotEmpty())
                        <div>
                            <dt class="text-sm font-medium text-gray-600">Valor Pago</dt>
                            <dd class="text-sm font-semibold text-green-600 mt-1">R$ {{ number_format($ordem->total_pago, 2, ',', '.') }}</dd>
                        </div>
                        @if($ordem->saldo_receber > 0)
                        <div>
                            <dt class="text-sm font-medium text-gray-600">Saldo a Pagar</dt>
                            <dd class="text-sm font-semibold text-yellow-600 mt-1">R$ {{ number_format($ordem->saldo_receber, 2, ',', '.') }}</dd>
                        </div>
                        @endif
                        @endif
                    </dl>
                </div>
            </div>

            @if($ordem->observacoes)
            <div class="border-t border-gray-200 pt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Observações</h3>
                <p class="text-sm text-gray-700">{{ $ordem->observacoes }}</p>
            </div>
            @endif
        </div>

        <!-- Status da Ordem -->
        <div class="glass-card rounded-2xl p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Status do Atendimento</h3>
            <div class="flex items-center justify-between">
                @foreach(['analise', 'aguardando_peca', 'em_reparo', 'concluido', 'entregue'] as $status)
                    @php
                        $isCurrent = $ordem->status === $status;
                        $isPast = array_search($ordem->status, array_keys(\App\Models\OrdemServico::STATUS)) > array_search($status, array_keys(\App\Models\OrdemServico::STATUS));
                    @endphp
                    <div class="flex flex-col items-center {{ $loop->last ? '' : 'flex-1' }}">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $isCurrent ? 'bg-brand-accent' : ($isPast ? 'bg-green-500' : 'bg-gray-300') }}">
                            @if($isPast || $isCurrent)
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            @endif
                        </div>
                        <span class="text-xs mt-2 text-center {{ $isCurrent ? 'font-semibold text-gray-900' : 'text-gray-500' }}">
                            {{ \App\Models\OrdemServico::STATUS[$status] }}
                        </span>
                    </div>
                    @if(!$loop->last)
                    <div class="flex-1 h-1 mx-2 {{ $isPast ? 'bg-green-500' : 'bg-gray-300' }}"></div>
                    @endif
                @endforeach
            </div>
        </div>

        <!-- Rodapé -->
        <div class="text-center mt-8">
            <p class="text-white text-sm text-opacity-80">
                Para mais informações, entre em contato conosco.
            </p>
            <p class="text-white text-xs text-opacity-60 mt-2">
                Link válido até: {{ $ordem->token_expires_at->format('d/m/Y') }}
            </p>
        </div>
    </div>
</body>
</html>
