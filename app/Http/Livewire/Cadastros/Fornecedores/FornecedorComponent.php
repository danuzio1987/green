<?php

namespace App\Http\Livewire\Cadastros\Fornecedores;

use App\Models\Cadastros\Fornecedor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class FornecedorComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['deleteFornecedor'];

    //variáveis da tabela
    public $name;

    //variávies auxiliares
    public $form_mode;
    public $actual_fornecedor;

    public function mount()
    {
        $this->start();
    }

    public function start()
    {
        //variáveis auxiliares
        $this->form_mode = "create";
        $this->actual_fornecedor = null;

        //variávies da tabela
        $this->name = "";
    }

    public function createFornecedor()
    {
        $customMessages = [
            'name.required'  => '✋ Fala sério... este campo é obrigatório!!!',
            'name.string'  => '✋ Tipos de dados inválidos. Tente novamente.',
            'name.max'  => '✋ Nome muito grande',
            'name.min'  => '✋ Nome muito curto',
            'name.unique'  => '😪 Esse nome já foi cadastrado Zé. Nome repetido não vale!!',
        ];

        $this->validate([
            'name' => [
                'required',
                Rule::unique("fornecedors")->whereNull("deleted_at"),
                'max:50',
                'min:3',
                'string'
                ],
        ], $customMessages);

        $fornecedor = new Fornecedor();
        $fornecedor->user_id = Auth::user()->id;
        $fornecedor->name = $this->name;
        $fornecedor->save();

        $this->dispatchBrowserEvent("sucesso-salva-fornecedor");

        $this->start();
    }

    public function showEditFormFornecedor($id)
    {
        $this->form_mode = "edit";
        $fornecedor = Fornecedor::findOrFail($id);
        $this->actual_fornecedor = $fornecedor->id;
        $this->name = $fornecedor->name;
    }

    public function editFornecedor()
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

        $fornecedor = Fornecedor::findOrFail($this->actual_fornecedor);
        $fornecedor->name = $this->name;
        $fornecedor->update();

        $this->dispatchBrowserEvent("sucesso-edita-fornecedor");

        $this->start();
    }

    public function deleteConfirmationFornecedor($id)
    {
        $this->actual_fornecedor = Fornecedor::findOrFail($id);
        $this->dispatchBrowserEvent("confirma-exclusao-fornecedor");
    }

    public function deleteFornecedor()
    {
        $fornecedor = Fornecedor::findOrFail($this->actual_fornecedor->id);
        $fornecedor->delete();
        $this->dispatchBrowserEvent("sucesso-deleta-fornecedor");
        $this->start();
    }

    public function cancel()
    {
        $this->start();
    }

    public function render()
    {
        return view('livewire.cadastros.fornecedores.fornecedor-component', [
            "fornecedores" => Fornecedor::orderBy("created_at", "DESC")->paginate(5)
        ]);
    }
}
