<?php

namespace App\Http\Livewire;

use App\Models\OrdemServico;
use Livewire\Component;

class EditarOrdemServico extends Component
{
    public $ordem_id;
    public $aparelho;
    public $defeito_relatado;
    public $status;
    public $orcamento;
    public $valor_aprovado;
    public $observacoes;
    public $tecnico_id;

    public function mount($ordem)
    {
        $this->ordem_id = $ordem->id;
        $this->aparelho = $ordem->aparelho;
        $this->defeito_relatado = $ordem->defeito_relatado;
        $this->status = $ordem->status;
        $this->orcamento = $ordem->orcamento;
        $this->valor_aprovado = $ordem->valor_aprovado;
        $this->observacoes = $ordem->observacoes;
        $this->tecnico_id = $ordem->tecnico_id;
    }

    protected $rules = [
        'aparelho' => 'required|string|max:100',
        'defeito_relatado' => 'required|string',
        'status' => 'required|in:analise,aguardando_peca,em_reparo,concluido,entregue,cancelado',
        'orcamento' => 'nullable|numeric|min:0',
        'valor_aprovado' => 'nullable|numeric|min:0',
        'observacoes' => 'nullable|string',
        'tecnico_id' => 'nullable|exists:users,id',
    ];

    public function save()
    {
        $this->validate();

        $ordem = OrdemServico::find($this->ordem_id);
        $ordem->update([
            'aparelho' => $this->aparelho,
            'defeito_relatado' => $this->defeito_relatado,
            'status' => $this->status,
            'orcamento' => $this->orcamento,
            'valor_aprovado' => $this->valor_aprovado,
            'observacoes' => $this->observacoes,
            'tecnico_id' => $this->tecnico_id,
        ]);

        session()->flash('success', 'Ordem de serviço atualizada com sucesso!');
    }

    public function render()
    {
        return view('livewire.editar-ordem-servico', [
            'ordem' => OrdemServico::find($this->ordem_id),
            'tecnicos' => \App\Models\User::where('role', 'tecnico')->get(),
        ]);
    }
}
