<?php

namespace App\Http\Livewire\Home;

use App\Models\Cadastros\Armazem;
use App\Models\Cadastros\Insumo;
use App\Models\Pedidos\Pedido;
use App\Models\Transferencias\Transferencia;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FeedComponent extends Component
{
    public $user;
    public $transferencias_pendentes;
    public $armazens;
    public $insumos;
    public $pedidos_pendentes;

    public function mount()
    {
        $this->user = Auth::user();
        $this->transferencias_pendentes = Transferencia::where("delivery_status", "andamento")->get();
        $this->armazens = Armazem::all();
        $this->insumos = Insumo::all();
        $this->pedidos_pendentes = Pedido::with("insumos")->where("tipo_entrega", "navio")->where("order_status", "aprovado")->get();
    }

    public function render()
    {
        return view('livewire.home.feed-component', [
            "users" => User::all()
        ]);
    }
}
