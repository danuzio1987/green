<?php

namespace App\Http\Livewire\Cadastros\Clientes;

use App\Models\Cadastros\Cliente;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class ClienteComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['deleteCliente'];

    //variáveis da tabela
    public $name;

    //variávies auxiliares
    public $form_mode;
    public $actual_cliente;

    public function mount()
    {
        $this->start();
    }

    public function start()
    {
        //variáveis auxiliares
        $this->form_mode = "create";
        $this->actual_cliente = null;

        //variávies da tabela
        $this->name = "";
    }

    public function createCliente()
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
                Rule::unique("clientes")->whereNull("deleted_at"),
                'max:50',
                'min:3',
                'string'
                ],
        ], $customMessages);

        $cliente = new Cliente();
        $cliente->user_id = Auth::user()->id;
        $cliente->name = $this->name;
        $cliente->save();

        $this->dispatchBrowserEvent("sucesso-salva-cliente");

        $this->start();
    }

    public function showEditFormCliente($id)
    {
        $this->form_mode = "edit";
        $cliente = Cliente::findOrFail($id);
        $this->actual_cliente = $cliente->id;
        $this->name = $cliente->name;
    }

    public function editCliente()
    {
        $customMessages = [
            'name.required'  => '✋ Fala sério... este campo é obrigatório!!!',
            'name.string'  => '✋ Tipos de dados inválidos. Tente novamente.',
            'name.max'  => '✋ Nome muito grande',
            'name.min'  => '✋ Nome muito curto',
        ];

        $this->validate([
            'name' => [
                'required',
                'max:50',
                'min:3',
                'string'
                ],
        ], $customMessages);

        $cliente = Cliente::findOrFail($this->actual_cliente);
        $cliente->name = $this->name;
        $cliente->update();

        $this->dispatchBrowserEvent("sucesso-edita-cliente");

        $this->start();
    }

    public function deleteConfirmationCliente($id)
    {
        $this->actual_cliente = Cliente::findOrFail($id);
        $this->dispatchBrowserEvent("confirma-exclusao-cliente");
    }

    public function deleteCliente()
    {
        $cliente = Cliente::findOrFail($this->actual_cliente->id);
        $cliente->delete();
        $this->dispatchBrowserEvent("sucesso-deleta-cliente");
        $this->start();
    }

    public function cancel()
    {
        $this->start();
    }

    public function render()
    {
        return view('livewire.cadastros.clientes.cliente-component', [
            "clientes" => Cliente::orderBy("created_at", "DESC")->paginate(5)
        ]);
    }
}
