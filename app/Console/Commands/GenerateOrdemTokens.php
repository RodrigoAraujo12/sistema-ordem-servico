<?php

namespace App\Console\Commands;

use App\Models\OrdemServico;
use Illuminate\Console\Command;

class GenerateOrdemTokens extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ordens:generate-tokens';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gerar tokens públicos para ordens existentes que não possuem';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Gerando tokens para ordens sem token...');

        $ordens = OrdemServico::whereNull('public_token')->get();

        if ($ordens->isEmpty()) {
            $this->info('Todas as ordens já possuem token!');
            return 0;
        }

        $bar = $this->output->createProgressBar($ordens->count());
        $bar->start();

        foreach ($ordens as $ordem) {
            $ordem->generatePublicToken();
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("✅ {$ordens->count()} tokens gerados com sucesso!");

        return 0;
    }
}
