<?php

namespace App\Http\Livewire;

use App\Models\OrdemServico;
use Livewire\Component;
use Livewire\WithPagination;

class ListarOrdensServico extends Component
{
    use WithPagination;

    public $search = '';
    public $filtroStatus = '';

    protected $queryString = ['search', 'filtroStatus', 'page'];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFiltroStatus()
    {
        $this->resetPage();
    }

    public function limparFiltros()
    {
        $this->search = '';
        $this->filtroStatus = '';
        $this->resetPage();
    }

    public function render()
    {
        $ordens = OrdemServico::query()
            ->with(['cliente', 'tecnico'])
            ->orderByDesc('created_at');

        if ($this->search) {
            $ordens->where(function ($query) {
                $query->where('numero_ordem', 'like', '%' . $this->search . '%')
                    ->orWhereHas('cliente', function ($q) {
                        $q->where('nome', 'like', '%' . $this->search . '%');
                    });
            });
        }

        if ($this->filtroStatus) {
            $ordens->where('status', $this->filtroStatus);
        }

        return view('livewire.listar-ordens-servico', [
            'ordensServico' => $ordens->paginate(10),
        ]);
    }
}


