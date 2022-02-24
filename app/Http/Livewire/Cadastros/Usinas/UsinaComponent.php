<?php

namespace App\Http\Livewire\Cadastros\Usinas;

use App\Models\Cadastros\Usina;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class UsinaComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['deleteUsina'];

    //variáveis da tabela
    public $name;

    //variávies auxiliares
    public $form_mode;
    public $actual_usina;

    public function mount()
    {
        $this->start();
    }

    public function start()
    {
        //variáveis auxiliares
        $this->form_mode = "create";
        $this->actual_usina = null;

        //variávies da tabela
        $this->name = "";
    }

    public function createUsina()
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
                Rule::unique("usinas")->whereNull("deleted_at"),
                'max:50',
                'min:3',
                'string'
                ],
        ], $customMessages);

        $usina = new Usina();
        $usina->user_id = Auth::user()->id;
        $usina->name = $this->name;
        $usina->save();

        $this->dispatchBrowserEvent("sucesso-salva-usina");

        $this->start();

    }

    public function showEditFormUsina($id)
    {
        $this->form_mode = "edit";
        $usina = Usina::findOrFail($id);
        $this->actual_usina = $usina->id;
        $this->name = $usina->name;
    }

    public function editUsina()
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

        $usina = Usina::findOrFail($this->actual_usina);
        $usina->name = $this->name;
        $usina->update();

        $this->dispatchBrowserEvent("sucesso-edita-usina");

        $this->start();
    }

    public function deleteConfirmationUsina($id)
    {
        $this->actual_usina = Usina::findOrFail($id);
        $this->dispatchBrowserEvent("confirma-exclusao-usina");
    }

    public function deleteUsina()
    {
        $usina = Usina::findOrFail($this->actual_usina->id);
        $usina->delete();
        $this->dispatchBrowserEvent("sucesso-deleta-usina");
        $this->start();
    }

    public function cancel()
    {
        $this->start();
    }

    public function render()
    {
        return view('livewire.cadastros.usinas.usina-component', [
            "usinas" => Usina::orderBy("name", "ASC")->paginate(5)
        ]);
    }
}
