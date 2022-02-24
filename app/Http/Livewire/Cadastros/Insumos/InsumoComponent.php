<?php

namespace App\Http\Livewire\Cadastros\Insumos;

use App\Models\Cadastros\Insumo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class InsumoComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['deleteInsumo'];

    //variáveis da tabela
    public $name;

    //variávies auxiliares
    public $form_mode;
    public $actual_insumo;

    public function mount()
    {
        $this->start();
    }

    public function start()
    {
        //variáveis auxiliares
        $this->form_mode = "create";
        $this->actual_insumo = null;

        //variávies da tabela
        $this->name = "";

    }

    public function createInsumo()
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
                Rule::unique("insumos")->whereNull("deleted_at"),
                'max:50',
                'min:3',
                'string'
                ],
        ], $customMessages);

        $insumo = new Insumo();
        $insumo->user_id = Auth::user()->id;
        $insumo->name = $this->name;
        $insumo->save();

        $this->dispatchBrowserEvent("sucesso-salva-insumo");

        $this->start();
    }

    public function showEditFormInsumo($id)
    {
        $this->form_mode = "edit";
        $insumo = Insumo::findOrFail($id);
        $this->actual_insumo = $insumo->id;
        $this->name = $insumo->name;
    }

    public function editInsumo()
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

        $insumo = Insumo::findOrFail($this->actual_insumo);
        $insumo->name = $this->name;
        $insumo->update();

        $this->dispatchBrowserEvent("sucesso-edita-insumo");

        $this->start();
    }

    public function deleteConfirmationInsumo($id)
    {
        $this->actual_insumo = Insumo::findOrFail($id);
        $this->dispatchBrowserEvent("confirma-exclusao-insumo");
    }

    public function deleteInsumo()
    {
        $insumo = Insumo::findOrFail($this->actual_insumo->id);
        $insumo->delete();
        $this->dispatchBrowserEvent("sucesso-deleta-insumo");
        $this->start();
    }

    public function cancel()
    {
        $this->start();
    }

    public function render()
    {
        return view('livewire.cadastros.insumos.insumo-component', [
            "insumos" => Insumo::orderBy("name", "ASC")->paginate(5)
        ]);
    }
}
