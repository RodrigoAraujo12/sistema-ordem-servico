<?php

namespace App\Http\Controllers;

use App\Models\Cliente;

class ClienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $clientes = Cliente::all();
        return view('clientes.index', compact('clientes'));
    }

    public function create()
    {
        return view('clientes.create');
    }

    public function store()
    {
        $validated = request()->validate([
            'nome' => 'required|string|max:100',
            'email' => 'required|email|unique:clientes,email',
            'telefone' => 'required|string|max:20',
            'cpf' => 'required|string|max:20|unique:clientes,cpf',
            'endereco' => 'nullable|string|max:255',
        ]);

        Cliente::create($validated);

        return redirect()->route('clientes.index')->with('success', 'Cliente cadastrado com sucesso!');
    }

    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    public function update(Cliente $cliente)
    {
        $validated = request()->validate([
            'nome' => 'required|string|max:100',
            'email' => 'required|email|unique:clientes,email,' . $cliente->id,
            'telefone' => 'required|string|max:20',
            'cpf' => 'required|string|max:20|unique:clientes,cpf,' . $cliente->id,
            'endereco' => 'nullable|string|max:255',
        ]);

        $cliente->update($validated);

        return redirect()->route('clientes.index')->with('success', 'Cliente atualizado com sucesso!');
    }

    public function show(Cliente $cliente)
    {
        $ordens = $cliente->ordensServico()
            ->with('tecnico')
            ->orderByDesc('created_at')
            ->get();

        // Estatísticas do cliente
        $totalOrdens = $ordens->count();
        $totalGasto = $ordens->whereIn('status', ['concluido', 'entregue'])->sum('valor_aprovado');
        $ordensAbertas = $ordens->whereNotIn('status', ['concluido', 'entregue', 'cancelado'])->count();

        return view('clientes.show', compact('cliente', 'ordens', 'totalOrdens', 'totalGasto', 'ordensAbertas'));
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return redirect()->route('clientes.index')->with('success', 'Cliente deletado com sucesso!');
    }
}
