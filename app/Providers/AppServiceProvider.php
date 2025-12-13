<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Forçar HTTPS em produção
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
            
            // Forçar root URL para evitar problemas de domínio
            $this->app['request']->server->set('HTTPS', 'on');
        }

        Livewire::component('listar-ordens-servico', \App\Http\Livewire\ListarOrdensServico::class);
        Livewire::component('criar-ordem-servico', \App\Http\Livewire\CriarOrdemServico::class);
        Livewire::component('editar-ordem-servico', \App\Http\Livewire\EditarOrdemServico::class);
    }
}
