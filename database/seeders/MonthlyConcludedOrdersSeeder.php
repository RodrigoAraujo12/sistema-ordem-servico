<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OrdemServico;
use App\Models\Cliente;
use Carbon\Carbon;

class MonthlyConcludedOrdersSeeder extends Seeder
{
    public function run(): void
    {
        $clientes = Cliente::take(3)->get();
        if ($clientes->isEmpty()) {
            return;
        }

        $startOfMonth = Carbon::now()->startOfMonth();
        $aparelhos = ['Notebook', 'Desktop', 'Smartphone'];

        foreach ($clientes as $idx => $cliente) {
            // Create two concluded orders per client this month
            for ($i = 0; $i < 2; $i++) {
                $entrada = $startOfMonth->copy()->addDays(rand(0, 10));
                $saida = $entrada->copy()->addDays(rand(1, 10));

                OrdemServico::create([
                    'cliente_id' => $cliente->id,
                    'numero_ordem' => 'OS-' . Carbon::now()->format('Ymd') . '-' . uniqid(),
                    'aparelho' => $aparelhos[array_rand($aparelhos)],
                    'defeito_relatado' => 'Teste de seeder mensal',
                    'status' => ['concluido', 'entregue'][rand(0, 1)],
                    'orcamento' => rand(200, 1200),
                    'valor_aprovado' => rand(250, 1500),
                    'data_entrada' => $entrada,
                    'data_saida' => $saida,
                    'tecnico_id' => rand(2, 3),
                    'observacoes' => 'Gerado para testar métricas mensais',
                ]);
            }
        }
    }
}
