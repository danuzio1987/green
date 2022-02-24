<?php

namespace App\Http\Livewire\Movimento;

use App\Models\Ajustes\Ajuste;
use App\Models\Cadastros\Armazem;
use App\Models\Cadastros\Insumo;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AjusteComponent extends Component
{
    protected $listeners = ["deleteAjuste"];

    //filter bar
    public $paginate;
    public $search_date;
    public $allAjustes;

    //variáveis da tabela de AJUSTE
    public $adjust_date;
    public $notes;

    //variáveis da tabela de DETALHAMENTO
    public $user_id;
    public $insumo_id;
    public $armazem_id;
    public $date_report;
    public $document;
    public $type;
    public $category;
    public $moviment_type;
    public $qtd;

    //variáveis auxiliares
    public $form_mode;
    public $armazens;
    public $insumos;
    public $actual_ajuste;


    public function mount()
    {
        $this->start();
    }

    public function start()
    {
        //filter bar
        $this->paginate = 5;
        $this->search_date = "";
        $this->allAjustes = Ajuste::all();

        //variáveis da tabela de AJUSTE
        $this->adjust_date = date("Y-m-d", strtotime(now()));
        $this->notes = "";

        //variáveis da tabela DETALHAMENTO
        $this->user_id = Auth::user()->id;
        $this->insumo_id = "";
        $this->armazem_id = "";
        $this->date_report = $this->adjust_date;
        $this->document = "";
        $this->type = "real";
        $this->category = "Ajuste Estoque";
        $this->moviment_type = "";
        $this->qtd = "";

        //variáveis auxiliares
        $this->form_mode = "create";
        $this->insumos = Insumo::all();
        $this->armazens = Armazem::all();
        $this->actual_ajuste = null;

    }

    public function createAjuste()
    {
        $customMessages = [
            'adjust_date.required'  => '✋ Campo obrigatório!',
            'moviment_type.required'  => '✋ Campo obrigatório!',
            'insumo_id.required'  => '✋ Campo obrigatório!',
            'armazem_id.required'  => '✋ Campo obrigatório!',
            'qtd.required'  => '✋ Campo obrigatório!',
        ];

        $this->validate([
            'adjust_date' => 'required|date',
            'moviment_type' => "required",
            'insumo_id' => "required",
            'armazem_id' => "required",
            'qtd' => 'required|numeric'
        ], $customMessages);

        $ajuste = new Ajuste();
        $ajuste->adjust_date = date("Y-m-d", strtotime($this->adjust_date));
        $ajuste->notes = $this->notes;
        $ajuste->save();

        $ajuste->details()->create([
            'user_id' => $this->user_id,
            'insumo_id' => $this->insumo_id,
            'armazem_id' => $this->armazem_id,
            'date_report' => date("Y-m-d", strtotime($ajuste->adjust_date)),
            'document' => $this->document,
            'type' => $this->type,
            'category' => $this->category,
            'moviment_type' => $this->moviment_type,
            'qtd' => $this->moviment_type === "entrada" ? $this->qtd : -$this->qtd
        ]);

        $this->dispatchBrowserEvent("sucesso-salva-ajuste");

        $this->start(); 

    }

    public function showEditFormAjuste($id)
    {
        $this->actual_ajuste = Ajuste::findOrFail($id);
        $this->form_mode = "edit";
        $this->adjust_date = date("Y-m-d", strtotime($this->actual_ajuste->adjust_date));
        $this->moviment_type = $this->actual_ajuste->details->moviment_type;
        $this->insumo_id = $this->actual_ajuste->details->insumo_id;
        $this->armazem_id = $this->actual_ajuste->details->armazem_id;
        $this->qtd = abs($this->actual_ajuste->details->qtd);
        $this->notes = $this->actual_ajuste->notes;
    }

    public function editAjuste()
    {
        $customMessages = [
            'adjust_date.required'  => '✋ Campo obrigatório!',
            'moviment_type.required'  => '✋ Campo obrigatório!',
            'insumo_id.required'  => '✋ Campo obrigatório!',
            'armazem_id.required'  => '✋ Campo obrigatório!',
            'qtd.required'  => '✋ Campo obrigatório!',
        ];

        $this->validate([
            'adjust_date' => 'required|date',
            'moviment_type' => "required",
            'insumo_id' => "required",
            'armazem_id' => "required",
            'qtd' => 'required|numeric'
        ], $customMessages);

        //atualizando tabela de AJUSTE
        $this->actual_ajuste->update([
            "adjust_date" => date("Y-m-d", strtotime($this->adjust_date)),
            "notes" => $this->notes
        ]);

        //atualizando a tabela de detalhes
        $this->actual_ajuste->details->update([
            'user_id' => Auth::user()->id,
            'insumo_id' => $this->insumo_id,
            'armazem_id' => $this->armazem_id,
            'date_report' => $this->actual_ajuste->adjust_date,
            'document' => $this->document,
            'type' => $this->type,
            'category' => $this->category,
            'moviment_type' => $this->moviment_type,
            'qtd' => $this->moviment_type === "entrada" ? $this->qtd : -$this->qtd
        ]);

        $this->dispatchBrowserEvent("sucesso-edita-ajuste");

        $this->start(); 

    }

    public function deleteConfirmationAjuste($id)
    {
        $this->actual_ajuste = Ajuste::findOrFail($id);
        $this->dispatchBrowserEvent("confirma-exclusao-ajuste");
    }

    public function deleteAjuste()
    {
       
        $this->actual_ajuste->delete();
        $this->actual_ajuste->details->delete();
        
        $this->dispatchBrowserEvent("sucesso-deleta-ajuste");
        $this->start();
    }

    public function cancel()
    {
        $this->start();
    }


    public function render()
    {
        return view('livewire.movimento.ajuste-component', [
            "ajustes" => Ajuste::when($this->search_date, function($query){
                                    $query->where('adjust_date', $this->search_date);
                                })
                                ->paginate($this->paginate),
        ]);
    }
}
