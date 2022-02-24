<?php

namespace App\Http\Livewire\Cadastros\Armazens;

use App\Models\Cadastros\Armazem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class ArmazemComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['deleteArmazem'];

    //variávies da tabela
    public $name;

    //variáveis auxiliares
    public $form_mode;
    public $actual_armazem;

    public function mount()
    {

    }

    public function start()
    {
        //variáveis auxiliares
        $this->form_mode = "create";
        $this->actual_armazem = null;

        //variávies da tabela
        $this->name = "";
    }

    public function createArmazem()
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
                Rule::unique("armazems")->whereNull("deleted_at"),
                'max:50',
                'min:3',
                'string'
                ],
        ], $customMessages);

        $armazem = new Armazem();
        $armazem->user_id = Auth::user()->id;
        $armazem->name = $this->name;
        $armazem->save();

        $this->dispatchBrowserEvent("sucesso-salva-armazem");

        $this->start();

    }

    public function showEditFormArmazem($id)
    {
        $this->form_mode = "edit";
        $armazem = Armazem::findOrFail($id);
        $this->actual_armazem = $armazem->id;
        $this->name = $armazem->name;
    }

    public function editArmazem()
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

        $armazem = Armazem::findOrFail($this->actual_armazem);
        $armazem->name = $this->name;
        $armazem->update();

        $this->dispatchBrowserEvent("sucesso-edita-armazem");

        $this->start();
    }

    public function deleteConfirmationArmazem($id)
    {
        $this->actual_armazem = Armazem::findOrFail($id);
        $this->dispatchBrowserEvent("confirma-exclusao-armazem");
    }

    public function deleteArmazem()
    {
        $armazem = Armazem::findOrFail($this->actual_armazem->id);
        $armazem->delete();
        $this->dispatchBrowserEvent("sucesso-deleta-armazem");
        $this->start();
    }

    public function cancel()
    {
        $this->start();
    }

    public function render()
    {
        return view('livewire.cadastros.armazens.armazem-component', [
            "armazens" => Armazem::orderBy("name", "asc")->paginate(5)
        ]);
    }
}
