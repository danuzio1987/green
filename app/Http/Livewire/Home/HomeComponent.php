<?php

namespace App\Http\Livewire\Home;

use App\Models\Cadastros\Armazem;
use App\Models\Cadastros\Cliente;
use App\Models\Cadastros\Fornecedor;
use App\Models\Cadastros\Insumo;
use App\Models\Cadastros\Produto;
use App\Models\Cadastros\Usina;
use App\Models\Detalhes\Detalhamento;
use Livewire\Component;
use Livewire\WithPagination;

class HomeComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

     //filter bar
     public $paginate;
     public $search_category;
     public $search_armazem;
     public $search_insumo;
     public $search_status;
     public $allLancamentos;

    //verificando cadastros básicos
    public $usinas_count;
    public $armazens_count;
    public $fornecedores_count;
    public $clientes_count;
    public $insumos_count;
    public $produtos_count;

    public $verifica;

    public $detalhes;
    public $armazens;
    public $insumos;
    public $data_inferior;

    public function mount()
    {
        $this->start();
    }

    public function start()
    {
        $this->verificaCadastros();

        $this->paginate = 5;

        $this->armazens = Armazem::with("insumos")->orderBy("name", "asc")->get();
        $this->insumos = Insumo::all();
        $this->allLancamentos = Detalhamento::all();
        $this->detalhes = Detalhamento::where("type", "!=", "canceled")->get();
        $this->data_inferior = date("Y-m-d", strtotime("2005-01-01"));
    }

    public function verificaCadastros()
    {
        $this->usinas_count = Usina::count();
        $this->armazens_count = Armazem::count();
        $this->fornecedores_count = Fornecedor::count();
        $this->clientes_count = Cliente::count();
        $this->insumos_count = Insumo::count();
        $this->produtos_count = Produto::count();


        if ($this->usinas_count == 0 ||  $this->armazens_count == 0 || $this->fornecedores_count == 0 || $this->clientes_count == 0 || $this->insumos_count == 0 || $this->produtos_count == 0) {
            $this->verifica = false;
        } else {
            $this->verifica = true;
        }

        return $this->verifica;

    }


    public function render()
    {
        return view('livewire.home.home-component', [
            "lancamentos" =>  Detalhamento::where("type", "!=", "canceled")
                                                ->when($this->search_category, function($query){
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
