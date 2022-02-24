<?php

namespace App\Http\Livewire\Cadastros\Tancagem;

use App\Models\Cadastros\Armazem;
use App\Models\Cadastros\Insumo;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TancagemComponent extends Component
{
    protected $listeners = ["deleteTancagem"];

    //variáveis de tabela
    public $insumo_id;
    public $armazem_id;
    public $volume;
    public $lastro;

    //variáveis auxiliares
    public $form_mode;
    public $insumos;
    public $armazens;
    public $actual_armazem;
    public $actual_insumo;
    public $view_mode = false;

    public function mount()
    {
        $this->start();
    }

    public function start()
    {
        //variáveis de tabela
        $this->insumo_id = "";
        $this->armazem_id = "";
        $this->volume = "";
        $this->lastro = "";

        //variáveis auxiliares
        $this->form_mode = "create";
        $this->actual_armazem = null;
        $this->actual_insumo = null;
        $this->insumos = Insumo::with("armazens")->get();
        $this->armazens = Armazem::with("insumos")->get();
    }

    

    public function createTancagem()
    {
        $customMessages = [
            'armazem_id.required'  => '✋ Campo obrigatório',
            'insumo_id.required'  => '✋ Campo obrigatório',
            'volume.required'  => '✋ Campo obrigatório',
            'volume.numeric'  => '✋ Dados inválidos!',
            'lastro.required'  => '✋ Campo obrigatório',
            'lastro.numeric'  => '✋ Dados inválidos!',
        ];

        $this->validate([
            'armazem_id' => "required",
            'insumo_id' => "required",
            'volume' => "required|numeric",
            'lastro' => "required|numeric"
        ], $customMessages);

        $armazem = Armazem::findOrFail($this->armazem_id);
        $armazem->insumos()->attach($this->insumo_id, [
            "volume" => $this->volume,
            "lastro" => $this->lastro
        ]);

        $this->dispatchBrowserEvent("sucesso-salva-tancagem");
        
        $this->start();
    }

    public function showEditFormTancagem($armazem_id, $insumo_id)
    {
        $this->form_mode = "edit";
        $this->actual_armazem = Armazem::findOrFail($armazem_id);
        $this->armazem_id = $this->actual_armazem->id;
        $this->actual_insumo = Insumo::findOrFail($insumo_id);
        $this->insumo_id = $this->actual_insumo->id;
        $this->volume = $this->actual_armazem->insumos->find($this->actual_insumo)->pivot->volume;
        $this->lastro = $this->actual_armazem->insumos->find($this->actual_insumo)->pivot->lastro;
    }

    public function editTancagem()
    {
        $armazem = Armazem::findOrFail($this->actual_armazem->id);
        $armazem->insumos()->updateExistingPivot($this->actual_insumo->id, [
            "volume" => $this->volume,
            "lastro" => $this->lastro
        ]);

        $this->start();
    }

    public function deleteConfirmationTancagem($armazem_id, $insumo_id)
    {
        $this->actual_armazem = Armazem::findOrFail($armazem_id);
        $this->actual_insumo = Insumo::findOrFail($insumo_id);
        $this->dispatchBrowserEvent("confirma-exclusao-tancagem");
    }

    public function deleteTancagem()
    {
        $armazem = Armazem::findOrFail($this->actual_armazem->id);
        $armazem->insumos()->detach($this->actual_insumo->id);
        $this->dispatchBrowserEvent("sucesso-deleta-tancagem");
        $this->start();
    }

    public function cancel()
    {
        $this->start();
    }


    public function render()
    {
        return view('livewire.cadastros.tancagem.tancagem-component');
    }
}
