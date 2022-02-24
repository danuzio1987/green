<?php

namespace App\Http\Livewire\Movimento;

use App\Models\Cadastros\Armazem;
use App\Models\Cadastros\Insumo;
use App\Models\Emprestimos\Emprestimo;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class EmprestimoComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    protected $listeners = ["deleteEmprestimo"];

    //filter bar
    public $paginate;


    //variáveis da tabela de EMPRÉSTIMO
    public $owner;
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
    public $actual_emprestimo;

    public function mount()
    {
        $this->start();
    }

    public function start()
    {
        //filter bar
        $this->paginate = 5;
        $this->allEmprestimos = Emprestimo::all();

        //variáveis da tabela de EMPRÉSTIMO
        $this->owner = "";
        $this->notes = "";

        //variáveis da tabela DETALHAMENTO
        $this->user_id = Auth::user()->id;
        $this->insumo_id = "";
        $this->armazem_id = "";
        $this->date_report = date("Y-m-d", strtotime(now()));
        $this->document = "";
        $this->type = "real";
        $this->category = "Empréstimo/Devolução";
        $this->moviment_type = "";
        $this->qtd = "";

        //variáveis auxiliares
        $this->form_mode = "create";
        $this->insumos = Insumo::all();
        $this->armazens = Armazem::all();
        $this->actual_emprestimo = null;

    }

    public function createEmprestimo()
    {
        $customMessages = [
            'date_report.required'  => '✋ Campo obrigatório!',
            'moviment_type.required'  => '✋ Campo obrigatório!',
            'insumo_id.required'  => '✋ Campo obrigatório!',
            'armazem_id.required'  => '✋ Campo obrigatório!',
            'qtd.required'  => '✋ Campo obrigatório!'
        ];

        $this->validate([
            'date_report' => 'required|date',
            'moviment_type' => 'required',
            'insumo_id' => 'required',
            'armazem_id' => 'required',
            'qtd' => 'required|numeric'
        ], $customMessages);

        //criando o empréstimo
         $emprestimo = new Emprestimo();
         $emprestimo->owner = $this->owner;
         $emprestimo->notes = $this->notes;
         $emprestimo->save();

         $emprestimo->details()->create([
            'user_id' => $this->user_id,
            'insumo_id' => $this->insumo_id,
            'armazem_id' => $this->armazem_id,
            'date_report' => date("Y-m-d", strtotime($this->date_report)),
            'document' => $this->document,
            'type' => $this->type,
            'category' => $this->category,
            'moviment_type' => $this->moviment_type,
            'qtd' => $this->moviment_type === "entrada" ? $this->qtd : -$this->qtd
         ]);

         $this->dispatchBrowserEvent("sucesso-salva-emprestimo");

        $this->start(); 
    }

    public function showEditFormEmprestimo($id)
    {
        $this->actual_emprestimo = Emprestimo::findOrFail($id);
        $this->form_mode = "edit";
        $this->date_report = date("Y-m-d", strtotime($this->actual_emprestimo->details->date_report));
        $this->moviment_type = $this->actual_emprestimo->details->moviment_type;
        $this->insumo_id = $this->actual_emprestimo->details->insumo_id;
        $this->armazem_id = $this->actual_emprestimo->details->armazem_id;
        $this->qtd = abs($this->actual_emprestimo->details->qtd);
        $this->owner = $this->actual_emprestimo->owner;
        $this->notes = $this->actual_emprestimo->notes;
    }

    public function editEmprestimo()
    {
        $customMessages = [
            'date_report.required'  => '✋ Campo obrigatório!',
            'moviment_type.required'  => '✋ Campo obrigatório!',
            'insumo_id.required'  => '✋ Campo obrigatório!',
            'armazem_id.required'  => '✋ Campo obrigatório!',
            'qtd.required'  => '✋ Campo obrigatório!'
        ];

        $this->validate([
            'date_report' => 'required|date',
            'moviment_type' => 'required',
            'insumo_id' => 'required',
            'armazem_id' => 'required',
            'qtd' => 'required|numeric'
        ], $customMessages);
        
        //atualizando a tabela de empréstimos
        $this->actual_emprestimo->update([
            "owner" => $this->owner,
            "notes" => $this->notes
        ]);

        //atualizando a tabela de DETALHES
        $this->actual_emprestimo->details->update([
            'user_id' => Auth::user()->id,
            'insumo_id' => $this->insumo_id,
            'armazem_id' => $this->armazem_id,
            'date_report' => $this->date_report,
            'document' => $this->document,
            'type' => $this->type,
            'category' => $this->category,
            'moviment_type' => $this->moviment_type,
            'qtd' => $this->moviment_type === "entrada" ? $this->qtd : -$this->qtd
        ]);

        $this->dispatchBrowserEvent("sucesso-edita-emprestimo");

        $this->start(); 

    }

    public function deleteConfirmationEmprestimo($id)
    {
        $this->actual_emprestimo = Emprestimo::findOrFail($id);
        $this->dispatchBrowserEvent("confirma-exclusao-emprestimo");
    }

    public function deleteEmprestimo()
    {
        $this->actual_emprestimo->delete();
        $this->actual_emprestimo->details->delete();
        
        $this->dispatchBrowserEvent("sucesso-deleta-emprestimo");
        $this->start();
    }

    public function cancel()
    {
        $this->start();
    }

    public function render()
    {
        return view('livewire.movimento.emprestimo-component', [
            "emprestimos" => Emprestimo::paginate($this->paginate),
        ]);
    }
}
