<?php

namespace App\Http\Livewire\Movimento;

use App\Models\Cadastros\Armazem;
use App\Models\Cadastros\Insumo;
use App\Models\Detalhes\Detalhamento;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class ExtratoComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    //filter bar
    public $paginate;
    public $search_armazem;
    public $search_insumo;
    public $search_category;
    public $search_status;
    public $users;
    public $allDetails;
    

    public $armazens;
    public $insumos;

    public function mount()
    {
        $this->start();
    }

    public function start()
    {
        $this->paginate = 5;
        $this->search_armazem = '';
        $this->search_insumo = '';
        $this->search_category = '';
        $this->search_status = '';
        $this->armazens = Armazem::all();
        $this->insumos = Insumo::all();
        $this->users = User::all();
        $this->allDetails = Detalhamento::all();
    }

    /**
     * where("type", "!=", "canceled")
     */

    public function render()
    {
        return view('livewire.movimento.extrato-component', [
            "lancamentos" => Detalhamento::when($this->search_category, function($query){
                                            $query->where('category', $this->search_category);
                                    })
                                    ->when($this->search_armazem, function($query){
                                        $query->where('armazem_id', $this->search_armazem);
                                    })
                                    ->when($this->search_insumo, function($query){
                                        $query->where('insumo_id', $this->search_insumo);
                                    })
                                    ->when($this->search_status, function($query){
                                        $query->where('type', $this->search_status);
                                    })
                                    ->paginate($this->paginate),
        ]);
    }
}
