@extends('layouts.app')

@section('title', 'Clientes')

@section('content')
<div class="py-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold page-title">Clientes</h2>
        @if(Auth::user()->isAdmin())
        <a href="{{ route('clientes.create') }}" class="px-4 py-2 bg-brand-border-strong text-white rounded-lg hover:bg-brand-accent-soft transition-colors shadow-md">+ Novo Cliente</a>
        @endif
    </div>

    <div class="glass-card rounded-2xl overflow-hidden">
        @if($clientes->isEmpty())
            <div class="p-6 text-center">
                <p class="text-gray-500 mb-4">Nenhum cliente cadastrado</p>
                <a href="{{ route('clientes.create') }}" class="text-blue-600 hover:text-blue-800">Cadastrar o primeiro cliente</a>
            </div>
        @else
            <table class="w-full glass-table rounded-xl overflow-hidden">
                <thead>
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-white">Nome</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-white">Email</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-white">Telefone</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-white">CPF</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-white">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($clientes as $cliente)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $cliente->nome }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $cliente->email }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $cliente->telefone }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $cliente->cpf }}</td>
                            <td class="px-6 py-4 text-sm space-x-2">
                                <a href="{{ route('clientes.show', $cliente) }}" class="text-blue-600 hover:text-blue-800">Ver Perfil</a>
                                @if(Auth::user()->isAdmin())
                                <a href="{{ route('clientes.edit', $cliente) }}" class="text-yellow-600 hover:text-yellow-800">Editar</a>
                                <form id="delete-cliente-{{ $cliente->id }}" method="POST" action="{{ route('clientes.destroy', $cliente) }}" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="text-red-600 hover:text-red-800" onclick="confirmDelete('Excluir Cliente', 'Tem certeza que deseja excluir {{ $cliente->nome }}?', 'delete-cliente-{{ $cliente->id }}')">Deletar</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection
