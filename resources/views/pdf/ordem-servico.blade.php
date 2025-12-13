<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Ordem de Serviço</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.6;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #0066cc;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #0066cc;
            font-size: 28px;
            margin-bottom: 5px;
        }
        .header p {
            color: #666;
            font-size: 12px;
        }
        .section {
            margin-bottom: 30px;
        }
        .section-title {
            background-color: #0066cc;
            color: white;
            padding: 10px 15px;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 15px;
            border-radius: 4px;
        }
        .info-grid {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        .info-row {
            display: table-row;
        }
        .info-label {
            display: table-cell;
            width: 30%;
            padding: 8px;
            background-color: #f5f5f5;
            font-weight: bold;
            border-bottom: 1px solid #ddd;
            font-size: 12px;
        }
        .info-value {
            display: table-cell;
            width: 70%;
            padding: 8px;
            border-bottom: 1px solid #ddd;
            font-size: 12px;
        }
        .two-columns {
            display: table;
            width: 100%;
        }
        .col {
            display: table-cell;
            width: 48%;
            padding-right: 20px;
        }
        .footer {
            border-top: 2px solid #0066cc;
            padding-top: 20px;
            text-align: center;
            font-size: 11px;
            color: #666;
            margin-top: 40px;
        }
        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 4px;
            color: white;
            font-weight: bold;
            font-size: 11px;
        }
        .status-analise {
            background-color: #3b82f6;
        }
        .status-aguardando {
            background-color: #f59e0b;
        }
        .status-reparo {
            background-color: #eab308;
        }
        .status-concluido {
            background-color: #10b981;
        }
        .status-entregue {
            background-color: #059669;
        }
        .status-cancelado {
            background-color: #ef4444;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>ORDEM DE SERVIÇO</h1>
            <p>Sistema de Assistência Técnica</p>
        </div>

        <div class="two-columns">
            <div class="col">
                <div class="section">
                    <div class="section-title">IDENTIFICAÇÃO DA ORDEM</div>
                    <div class="info-grid">
                        <div class="info-row">
                            <div class="info-label">Número da Ordem</div>
                            <div class="info-value"><strong>{{ $ordem->numero_ordem }}</strong></div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Data de Entrada</div>
                            <div class="info-value">{{ $ordem->data_entrada->format('d/m/Y') }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Status</div>
                            <div class="info-value">
                                <span class="status-badge status-{{ str_replace('_', '', $ordem->status) }}">
                                    {{ $ordem->status_formatado }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="section">
                    <div class="section-title">DATAS</div>
                    <div class="info-grid">
                        <div class="info-row">
                            <div class="info-label">Data de Saída</div>
                            <div class="info-value">
                                @if($ordem->data_saida)
                                    {{ $ordem->data_saida->format('d/m/Y') }}
                                @else
                                    <em>Não concluído</em>
                                @endif
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Técnico Responsável</div>
                            <div class="info-value">
                                @if($ordem->tecnico)
                                    {{ $ordem->tecnico->name }}
                                @else
                                    <em>Não atribuído</em>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="section">
            <div class="section-title">INFORMAÇÕES DO CLIENTE</div>
            <div class="info-grid">
                <div class="info-row">
                    <div class="info-label">Nome</div>
                    <div class="info-value">{{ $ordem->cliente->nome }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Telefone</div>
                    <div class="info-value">{{ $ordem->cliente->telefone ?? '-' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Email</div>
                    <div class="info-value">{{ $ordem->cliente->email ?? '-' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">CPF</div>
                    <div class="info-value">{{ $ordem->cliente->cpf ?? '-' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Endereço</div>
                    <div class="info-value">{{ $ordem->cliente->endereco ?? '-' }}</div>
                </div>
            </div>
        </div>

        <div class="two-columns">
            <div class="col">
                <div class="section">
                    <div class="section-title">EQUIPAMENTO</div>
                    <div class="info-grid">
                        <div class="info-row">
                            <div class="info-label">Aparelho</div>
                            <div class="info-value"><strong>{{ $ordem->aparelho }}</strong></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="section">
                    <div class="section-title">VALORES</div>
                    <div class="info-grid">
                        <div class="info-row">
                            <div class="info-label">Orçamento</div>
                            <div class="info-value"><strong>R$ {{ number_format($ordem->orcamento ?? 0, 2, ',', '.') }}</strong></div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Valor Aprovado</div>
                            <div class="info-value"><strong>R$ {{ number_format($ordem->valor_aprovado ?? 0, 2, ',', '.') }}</strong></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="section">
            <div class="section-title">DEFEITO RELATADO</div>
            <div style="padding: 15px; background-color: #f9f9f9; border: 1px solid #ddd; border-radius: 4px; font-size: 12px; line-height: 1.6;">
                {{ $ordem->defeito_relatado }}
            </div>
        </div>

        @if($ordem->observacoes)
        <div class="section">
            <div class="section-title">OBSERVAÇÕES</div>
            <div style="padding: 15px; background-color: #f9f9f9; border: 1px solid #ddd; border-radius: 4px; font-size: 12px; line-height: 1.6;">
                {{ $ordem->observacoes }}
            </div>
        </div>
        @endif

        <div class="footer">
            <p>Este documento foi gerado em {{ now()->format('d/m/Y H:i:s') }}</p>
            <p>Sistema de Ordens de Serviço para Assistência Técnica</p>
        </div>
    </div>
</body>
</html>
