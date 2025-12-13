@extends('layouts.app')

@section('title', 'Criar Ordem de Serviço')

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
    <h2 class="text-3xl font-bold page-title mb-6">Criar Nova Ordem de Serviço</h2>
    
    <div class="glass-card rounded-2xl p-6">
        <form method="POST" action="{{ route('ordensservico.store') }}" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-2">Cliente *</label>
                    <select name="cliente_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('cliente_id') border-red-500 @enderror">
                        <option value="">Selecione um cliente</option>
                        @foreach($clientes as $cliente)
                            <option value="{{ $cliente->id }}" @selected(old('cliente_id') == $cliente->id)>{{ $cliente->nome }}</option>
                        @endforeach
                    </select>
                    @error('cliente_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-2">Aparelho *</label>
                    <input type="text" name="aparelho" value="{{ old('aparelho') }}" placeholder="Ex: Notebook, Desktop..." 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('aparelho') border-red-500 @enderror">
                    @error('aparelho') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-900 mb-2">Defeito Relatado *</label>
                    <textarea name="defeito_relatado" rows="4" placeholder="Descreva o defeito relatado pelo cliente..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('defeito_relatado') border-red-500 @enderror">{{ old('defeito_relatado') }}</textarea>
                    @error('defeito_relatado') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-2">Orçamento</label>
                    <div class="relative">
                        <span class="absolute left-3 top-2.5 text-gray-500">R$</span>
                        <input type="number" name="orcamento" step="0.01" value="{{ old('orcamento') }}" placeholder="0.00"
                            class="w-full pl-8 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('orcamento') border-red-500 @enderror">
                    </div>
                    @error('orcamento') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-2">Valor Aprovado</label>
                    <div class="relative">
                        <span class="absolute left-3 top-2.5 text-gray-500">R$</span>
                        <input type="number" name="valor_aprovado" step="0.01" value="{{ old('valor_aprovado') }}" placeholder="0.00"
                            class="w-full pl-8 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('valor_aprovado') border-red-500 @enderror">
                    </div>
                    @error('valor_aprovado') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-900 mb-2">Observações</label>
                    <textarea name="observacoes" rows="3" placeholder="Observações adicionais..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('observacoes') border-red-500 @enderror">{{ old('observacoes') }}</textarea>
                    @error('observacoes') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="px-6 py-2 bg-brand-border-strong text-white rounded-lg hover:bg-brand-accent-soft transition-colors shadow-md font-medium">
                    Criar Ordem de Serviço
                </button>
                <a href="{{ route('ordensservico.index') }}" class="px-6 py-2 bg-gray-300 text-gray-900 rounded-lg hover:bg-gray-400 font-medium">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
