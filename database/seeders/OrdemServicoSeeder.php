<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\OrdemServico;
use Illuminate\Database\Seeder;

class OrdemServicoSeeder extends Seeder
{
    public function run(): void
    {
        $clientes = Cliente::all();

        $aparelhos = ['Notebook', 'Desktop', 'Impressora', 'Monitor', 'Teclado'];
        $defeitos = [
            'Não liga',
            'Tela com problemas',
            'Superaquecimento',
            'Bateria não carrega',
            'Teclado com teclas presas',
            'Som não funciona',
            'Conexão Wi-Fi instável',
        ];

        foreach ($clientes as $cliente) {
            for ($i = 0; $i < 2; $i++) {
                OrdemServico::create([
                    'cliente_id' => $cliente->id,
                    'numero_ordem' => 'OS-' . str_pad($cliente->id . $i + 1, 6, '0', STR_PAD_LEFT),
                    'aparelho' => $aparelhos[array_rand($aparelhos)],
                    'defeito_relatado' => $defeitos[array_rand($defeitos)],
                    'status' => ['analise', 'aguardando_peca', 'em_reparo', 'concluido', 'entregue'][array_rand(['analise', 'aguardando_peca', 'em_reparo', 'concluido', 'entregue'])],
                    'orcamento' => rand(100, 1000),
                    'valor_aprovado' => rand(100, 1000),
                    'data_entrada' => now()->subDays(rand(1, 30)),
                    'data_conclusao' => rand(0, 1) ? now() : null,
                    'tecnico_id' => rand(2, 3),
                    'observacoes' => 'Observações do serviço...',
                ]);
            }
        }
    }
}
