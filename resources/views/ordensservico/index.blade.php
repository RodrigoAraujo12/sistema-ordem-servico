@extends('layouts.app')

@section('title', 'Ordens de Serviço')

@section('content')
<div class="py-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold page-title">Ordens de Serviço</h2>
        @if(Auth::user()->isAdmin())
        <a href="{{ route('ordensservico.create') }}" class="px-4 py-2 bg-brand-border-strong text-white rounded-lg hover:bg-brand-accent-soft transition-colors shadow-md">+ Nova Ordem</a>
        @endif
    </div>
    
    <div class="glass-card rounded-2xl p-6">
        <form method="GET" action="{{ route('ordensservico.index') }}" class="mb-6 flex gap-4">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por número ou cliente..." 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="">Todos os status</option>
                @foreach(\App\Models\OrdemServico::STATUS as $key => $label)
                    <option value="{{ $key }}" @selected(request('status') === $key)>{{ $label }}</option>
                @endforeach
            </select>
            <button type="submit" class="px-4 py-2 bg-brand-accent text-white rounded-lg hover:bg-brand-accent-soft transition-colors shadow-md">
                Buscar
            </button>
            <a href="{{ route('ordensservico.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors shadow-md">
                Limpar
            </a>
        </form>

        @if($ordensServico->isEmpty())
            <div class="text-center py-8">
                <p class="text-gray-500">Nenhuma ordem de serviço encontrada.</p>
            </div>
        @else
            <div class="overflow-x-auto rounded-xl">
                <table class="w-full glass-table rounded-xl overflow-hidden">
                    <thead>
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-white">Número</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-white">Cliente</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-white">Aparelho</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-white">Status</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-white">Data Entrada</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-white">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach($ordensServico as $ordem)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm font-medium text-blue-600">
                                    <a href="{{ route('ordensservico.show', $ordem) }}" class="hover:underline">
                                        {{ $ordem->numero_ordem }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $ordem->cliente->nome }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $ordem->aparelho }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="px-3 py-1 rounded-full text-white text-xs font-medium
                                        @if($ordem->status === 'concluido' || $ordem->status === 'entregue') bg-green-500
                                        @elseif($ordem->status === 'cancelado') bg-red-500
                                        @elseif($ordem->status === 'em_reparo') bg-yellow-500
                                        @else bg-blue-500 @endif">
                                        {{ $ordem->status_formatado }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $ordem->data_entrada->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 text-sm space-x-2">
                                    <a href="{{ route('ordensservico.show', $ordem) }}" class="text-blue-600 hover:text-blue-800">Ver</a>
                                    <a href="{{ route('ordensservico.edit', $ordem) }}" class="text-yellow-600 hover:text-yellow-800">Editar</a>
                                    <a href="{{ route('pdf.gerar', $ordem) }}" class="text-red-600 hover:text-red-800">PDF</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $ordensServico->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
