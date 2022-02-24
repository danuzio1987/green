<?php

namespace App\Http\Livewire\Cadastros\Produtos;

use App\Models\Cadastros\Insumo;
use App\Models\Cadastros\Produto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class ProdutoComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['deleteProduto'];

    //variáveis da tabela
    public $name;
    public $insumo_id;
    public $percent;

    //variávies auxiliares
    public $form_mode;
    public $actual_produto;
    public $insumos;
    public $i;
    public $inputs;
    public $verifica_soma;

    public function mount()
    {
        $this->start();
    }

    public function start()
    {
        //variáveis auxiliares
        $this->form_mode = "create";
        $this->actual_produto = null;
        $this->insumos = Insumo::all();

        //variávies da tabela
        $this->name = "";
        $this->inputs = [];
        $this->i = 1;
        $this->verifica_soma = 0;
    }

    public function resetInputFields()
    {
        $this->insumo_id = "";
        $this->percent = "";
    }

    public function add($i)
    {
        $i = $i + 1;
        $this->i = $i;
        array_push($this->inputs, $i);
    }

    public function remove($i)
    {
        unset($this->inputs[$i]);
    }

    public function createProduto()
    {
        $customMessages = [
            'name.required'  => '✋ Fala sério... este campo é obrigatório!!!',
            'name.string'  => '✋ Tipos de dados inválidos. Tente novamente.',
            'name.max'  => '✋ Nome muito grande',
            'name.min'  => '✋ Nome muito curto',
            'name.unique'  => '😪 Esse nome já foi cadastrado Zé. Nome repetido não vale!!',
            'insumo_id.0.required'  => '✋ Este campo é obrigatório!',
            'percent.0.required'  => '✋ Este campo é obrigatório!!!',
            'insumo_id.*.required'  => '✋ Este campo é obrigatório!',
            'percent.*.required'  => '✋ Este campo é obrigatório!!!',
        ];

        $this->validate([
            'name' => [
                'required',
                Rule::unique("produtos")->whereNull("deleted_at"),
                'max:50',
                'min:3',
                'string'
                ],
            'insumo_id.0' => "required",
            'percent.0' => "required",
            'insumo_id.*' => "required",
            'percent.*' => "required"
        ], $customMessages);

        $produto = new Produto();
        $produto->user_id = Auth::user()->id;
        $produto->name = $this->name;
        $produto->save();

        foreach ($this->insumo_id as $key => $value) {
            $produto->insumos()->attach($this->insumo_id[$key], [
                "percent" => $this->percent[$key]
            ]);
        }

        $this->dispatchBrowserEvent("sucesso-salva-produto");

        $this->start(); 
        $this->resetInputFields();  
    }

    public function showEditFormProduto($id)
    {
        $this->form_mode = "edit";
        $produto = Produto::findOrFail($id);
        $this->actual_produto = $produto->id;
        $this->name = $produto->name;
    }

    public function editProduto()
    {
        $customMessages = [
            'name.required'  => '✋ Fala sério... este campo é obrigatório!!!',
            'name.string'  => '✋ Tipos de dados inválidos. Tente novamente.',
            'name.max'  => '✋ Nome muito grande',
            'name.min'  => '✋ Nome muito curto'
        ];

        $this->validate([
            'name' => [
                'required',
                'max:50',
                'min:3',
                'string'
                ],
        ], $customMessages);

        $produto = Produto::findOrFail($this->actual_produto);
        $produto->name = $this->name;
        $produto->update();

        $this->dispatchBrowserEvent("sucesso-edita-produto");

        $this->start();
    }

    public function deleteConfirmationProduto($id)
    {
        $this->actual_produto = Produto::findOrFail($id);
        $this->dispatchBrowserEvent("confirma-exclusao-produto");
    }

    public function deleteProduto()
    {
        $produto = Produto::findOrFail($this->actual_produto->id);
        $produto->delete();
        $produto->insumos()->detach();
        $this->dispatchBrowserEvent("sucesso-deleta-produto");
        $this->start();
    }

    public function cancel()
    {
        $this->start();
    }

    public function verificaSoma()
    {
        if (!empty($this->percent)) {
            $this->verifica_soma = array_sum($this->percent);
            /*
            foreach ($this->percent as $key => $value) {
                $this->verifica_soma = $this->verifica_soma + $value;
            }
            */
        }
    }
    
    public function render()
    {
        $this->verificaSoma();

        return view('livewire.cadastros.produtos.produto-component', [
            "produtos" => Produto::orderBy("created_at", "DESC")->paginate(5)
        ]);
    }
}
