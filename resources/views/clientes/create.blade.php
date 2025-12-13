@extends('layouts.app')

@section('title', 'Novo Cliente')

@section('content')
<div class="py-6">
    <div class="mb-4">
        <a href="{{ route('clientes.index') }}" class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-brand-accent to-brand-border-strong text-white rounded-lg hover:shadow-lg hover:scale-105 transition-all duration-200 font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Voltar para Clientes
        </a>
    </div>
    <h2 class="text-3xl font-bold page-title mb-6">Cadastrar Novo Cliente</h2>

    <div class="glass-card rounded-2xl p-6">
        <form method="POST" action="{{ route('clientes.store') }}" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-900 mb-2">Nome Completo *</label>
                    <input type="text" name="nome" value="{{ old('nome') }}" placeholder="Ex: João Silva" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('nome') border-red-500 @enderror">
                    @error('nome') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-2">Email *</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="exemplo@email.com"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror">
                    @error('email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-2">Telefone *</label>
                    <input type="text" name="telefone" id="telefone" value="{{ old('telefone') }}" placeholder="(11) 99999-9999" maxlength="15"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('telefone') border-red-500 @enderror">
                    @error('telefone') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-2">CPF *</label>
                    <input type="text" name="cpf" id="cpf" value="{{ old('cpf') }}" placeholder="000.000.000-00" maxlength="14"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('cpf') border-red-500 @enderror">
                    @error('cpf') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-900 mb-2">Endereço</label>
                    <textarea name="endereco" rows="3" placeholder="Rua, número, bairro, cidade..." 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('endereco') border-red-500 @enderror">{{ old('endereco') }}</textarea>
                    @error('endereco') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="px-6 py-2 bg-brand-border-strong text-white rounded-lg hover:bg-brand-accent-soft transition-colors shadow-md font-medium">
                    Cadastrar Cliente
                </button>
                <a href="{{ route('clientes.index') }}" class="px-6 py-2 bg-gray-300 text-gray-900 rounded-lg hover:bg-gray-400 font-medium">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
