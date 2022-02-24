<?php

namespace App\Http\Livewire\Cadastros\Produtos;

use App\Models\Cadastros\Insumo;
use App\Models\Cadastros\Produto;
use Livewire\Component;

class ProdutoEdit extends Component
{

    protected $listeners = ["update" => 'render', 'deleteInsumo', 'deleteProduto' ];

    public $produto;

    //variáveis da tabela de PRODUTO
    public $name;
    
    //variáveis da tabela pivô
    public $insumo_id;
    public $percent;


    //variávies auxiliares
    
    public $form_mode;
    public $insumos;
    public $verifica_soma;
    public $actual_insumo;

    /*
    public $actual_produto;
    
    public $i;
    public $inputs;
    
    */

    public function mount($produto)
    {
        $this->produto = $produto;
        $this->start();
    }

    public function start()
    {
        //variáveis da tabela
        $this->name = $this->produto->name;


        $this->form_mode = "create";
        $this->insumos = Insumo::all();
        $this->verifica_soma = $this->produto->insumos->sum('pivot.percent');

        $this->actual_insumo = "";
        $this->percent = "";
    }

    public function updateProduto()
    {
        $customMessages = [
            'name.required'  => '✋ Fala sério... este campo é obrigatório!!!'
        ];

        $this->validate([
            'name' => "required",
        ], $customMessages);

        $produto = Produto::findOrFail($this->produto->id);
        $produto->name = $this->name;
        $produto->update();

        $this->dispatchBrowserEvent("sucesso-edita-produto");
       
        $this->emit("update");

        $this->mount($this->produto);

        redirect(route('produtos.edit', $this->produto->id));

    }

 

    public function inserirInsumo()
    {
        $customMessages = [
            'insumo_id.required'  => '✋ Campo obrigatório!',
            'percent.required'  => '✋ Campo obrigatório!',
        ];

        $this->validate([
            'insumo_id' => 'required',
            'percent' => "required",
        ], $customMessages);

        $this->produto->insumos()->attach($this->insumo_id, [
            "percent" => $this->percent
        ]);
        $this->emit("update");

        $this->mount($this->produto);
        redirect(route('produtos.edit', $this->produto->id));
    }

    public function showEditFormInsumo($id)
    {
        $this->form_mode = "edit";
        $this->actual_insumo = $this->produto->insumos()->find($id);
        $this->insumo_id = $this->actual_insumo->id;
        $this->percent = $this->actual_insumo->pivot->percent;
    }

    public function editInsumo()
    {
        $this->produto->insumos()->find($this->actual_insumo->id)->pivot->update([
            "percent" => $this->percent
        ]);

        $this->verSoma();

        $this->dispatchBrowserEvent("sucesso-edita-produto");
       
        $this->emit("update");

        $this->mount($this->produto);

        redirect(route('produtos.edit', $this->produto->id));

    }

    public function verSoma()
    {
        $this->verifica_soma = $this->produto->insumos->sum('pivot.percent');
    }

    public function resetFormInput()
    {
        $this->form_mode = "create";
        $this->actual_insumo = "";
        $this->insumo_id = "";
        $this->percent = "";
    }

    public function deleteConfirmationInsumo($id)
    {
        $this->actual_insumo = $this->produto->insumos->find($id);
        $this->dispatchBrowserEvent("confirma-exclusao-insumo");
    }

    public function deleteInsumo()
    {
        $this->produto->insumos()->detach($this->actual_insumo->id);

        $this->dispatchBrowserEvent("sucesso-deleta-insumo");
        $this->emit("update");
        $this->mount($this->produto);

        redirect(route('produtos.edit', $this->produto->id));
    }

    public function deleteConfirmationProduto()
    {
        $this->dispatchBrowserEvent("confirma-exclusao-produto");
    }

    public function deleteProduto()
    {
        $produto = Produto::findOrFail($this->produto->id);
        $produto->delete();
        $produto->insumos()->detach();
        $this->dispatchBrowserEvent("sucesso-deleta-produto");
        $this->redirect(route('produtos.index'));
    }

    public function render()
    {
        return view('livewire.cadastros.produtos.produto-edit');
    }
}
