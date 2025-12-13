<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Livewire::component('listar-ordens-servico', \App\Http\Livewire\ListarOrdensServico::class);
        Livewire::component('criar-ordem-servico', \App\Http\Livewire\CriarOrdemServico::class);
        Livewire::component('editar-ordem-servico', \App\Http\Livewire\EditarOrdemServico::class);
    }
}
