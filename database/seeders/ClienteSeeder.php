<?php

namespace Database\Seeders;

use App\Models\Cliente;
use Illuminate\Database\Seeder;

class ClienteSeeder extends Seeder
{
    public function run(): void
    {
        Cliente::create([
            'nome' => 'João Silva',
            'email' => 'joao@example.com',
            'telefone' => '(11) 98765-4321',
            'cpf' => '12345678901',
            'endereco' => 'Rua A, 123 - São Paulo, SP',
        ]);

        Cliente::create([
            'nome' => 'Maria Santos',
            'email' => 'maria@example.com',
            'telefone' => '(11) 99876-5432',
            'cpf' => '98765432101',
            'endereco' => 'Avenida B, 456 - São Paulo, SP',
        ]);

        Cliente::create([
            'nome' => 'Pedro Oliveira',
            'email' => 'pedro@example.com',
            'telefone' => '(11) 97654-3210',
            'cpf' => '56789012345',
            'endereco' => 'Rua C, 789 - São Paulo, SP',
        ]);
    }
}
