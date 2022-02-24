<?php

namespace App\Http\Livewire\Cadastros;

use App\Models\Cadastros\Armazem;
use App\Models\Cadastros\Cliente;
use App\Models\Cadastros\Fornecedor;
use App\Models\Cadastros\Insumo;
use App\Models\Cadastros\Produto;
use App\Models\Cadastros\Usina;
use App\Models\Pedidos\Pedido;
use Livewire\Component;

class CadastroIndex extends Component
{

        public $usinas;
        public $armazens;
        public $fornecedores;
        public $clientes;
        public $insumos;
        public $produtos;
        public $tancagens;
        public $pedidos;

    public function mount()
    {
        $this->start();
    }

    public function start()
    {
        $this->usinas = Usina::all();
        $this->armazens = Armazem::all();
        $this->fornecedores = Fornecedor::all();
        $this->clientes = Cliente::all();
        $this->insumos = Insumo::all();
        $this->produtos = Produto::all();
        $this->tancagens = Armazem::with("insumos")->get();
        $this->pedidos = Pedido::all();
    }





    public function render()
    {
        return view('livewire.cadastros.cadastro-index');
    }
}
