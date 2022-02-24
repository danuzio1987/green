<?php

namespace App\Http\Livewire\Pedidos;

use App\Models\Cadastros\Armazem;
use App\Models\Cadastros\Cliente;
use App\Models\Cadastros\Fornecedor;
use App\Models\Cadastros\Insumo;
use App\Models\Cadastros\Produto;
use App\Models\Cadastros\Usina;
use App\Models\Pedidos\Entrega;
use App\Models\Pedidos\Pedido;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class PedidoList extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'refresh-me' => '$refresh',
        'deleteEntrega'
    ];

    //verificando cadastros básicos
    public $usinas_count;
    public $armazens_count;
    public $fornecedores_count;
    public $clientes_count;
    public $insumos_count;
    public $produtos_count;

    public $verifica;

    //variáveis do card
    public $total_pedidos;

    //variávies do filtro
    public $paginate;

    //variáveis auxiliares
    public $actual_pedido;
    public $pedido_id;
    public $insumos;
    public $armazens;

    public $find_insumo;

    //variáveis da entrega
    public $delivery_date;
    public $insumo_id;
    public $armazem_id;
    public $qtd_delivered;
    public $notes;
    public $entregas;

    public $actual_entrega;

 


    public function mount()
    {
        $this->verificaCadastros();
        if ($this->verifica == true) {
            $this->start();
        }
    }

    public function start()
    {
        //variávies do filtro
        $this->paginate = 7;
        $this->pedido_id = Pedido::count() > 0 ? Pedido::first()->id : null;
        $this->actual_pedido = Pedido::with("fornecedor")->with("insumos")->with("usina")->with("entregas")->findOrFail($this->pedido_id);
        $this->insumos = $this->actual_pedido->insumos;
        $this->armazens = Armazem::all();
        $this->find_insumo = Insumo::all();

        $this->actual_entrega = null;

        $this->entregas = $this->actual_pedido->entregas;

        $this->clearForm();
        
    }

    public function clearForm()
    {
        //variáveis da entrega
        $this->delivery_date = "";
        $this->insumo_id = "";
        $this->armazem_id = "";
        $this->qtd_delivered = "";
        $this->notes = "";      
    }

    public function findPedido($pedido_id)
    {
        $this->pedido_id = $pedido_id;
        $this->actual_pedido = Pedido::findOrFail($this->pedido_id);
        $this->insumos = $this->actual_pedido->insumos;
        $this->entregas = $this->actual_pedido->entregas;
    }

    public function novaEntrega()
    {
        $customMessages = [
            'delivery_date.required'  => '✋ Campo obrigatório!',
            'delivery_date.date'  => '✋ Formato inválido!',
            'insumo_id.required'  => '✋ Campo obrigatório!',
            'armazem_id.required'  => '✋ Campo obrigatório!',
            'qtd_delivered.required'  => '✋ Campo obrigatório!',
            'notes.string'  => '✋ Formato inválido!',
            
        ];

        $this->validate([
            'delivery_date' => "required|date",
            'insumo_id' => 'required',
            'armazem_id' => 'required',
            'qtd_delivered' => "required|numeric",
            'notes' => 'nullable|string' 
        ], $customMessages);

        $entrega = new Entrega();
        $entrega->pedido_id = $this->actual_pedido->id;
        $entrega->insumo_id = $this->insumo_id;
        $entrega->armazem_id = $this->armazem_id;
        $entrega->delivery_date = date("Y-m-d", strtotime($this->delivery_date));
        $entrega->qtd_delivered = $this->qtd_delivered;
        $entrega->notes = $this->notes;
        $entrega->save();

        //atualiza a quantidade real recebida do pedido
        //$this->actual_pedido->insumos->find($this->insumo_id)->pivot->update([
        $this->actual_pedido->insumos()->where("insumo_id", $this->insumo_id)->where("armazem_id", $this->armazem_id)->update([
            "qtd_real" => Entrega::where("pedido_id", $this->actual_pedido->id)->where("insumo_id", $this->insumo_id)->where("armazem_id", $this->armazem_id)->sum("qtd_delivered")
        ]);

        //lança a quantidade real no detalhamento para aparecer nos relatórios
        $this->actual_pedido->details()->create(
            [
                'user_id' => Auth::user()->id,
                'insumo_id' => $this->insumo_id,
                'armazem_id' => $this->armazem_id,
                'product_id' => null,
                'date_report' => date("Y-m-d", strtotime($this->delivery_date)),
                'document' => $this->actual_pedido->document,
                'type' => "real",
                'category' => "Entrada Navio",
                'moviment_type' => "entrada",
                'qtd' => $this->qtd_delivered
            ]
        );


        //atualizando o valor do previsto
        //se a quantidade real for maior que a prevista, todo o forecast do detalhamento deve ser excluído
        if ( ($this->actual_pedido->insumos()->where("insumo_id", $this->insumo_id)->where("armazem_id", $this->armazem_id)->sum("qtd_forecast") - $this->actual_pedido->insumos()->where("insumo_id", $this->insumo_id)->where("armazem_id", $this->armazem_id)->sum("qtd_real") ) <= 0 ) 
        {
            $this->actual_pedido->details()->where("insumo_id", $this->insumo_id)->where("armazem_id", $this->armazem_id)->where("type", "forecast")->delete();
        } else {
            $this->actual_pedido->details()->where("insumo_id", $this->insumo_id)->where("armazem_id", $this->armazem_id)->where("type", "forecast")->update([
                //"qtd" => $this->actual_pedido->insumos->find($this->insumo_id)->pivot->qtd_forecast - $this->actual_pedido->insumos->find($this->insumo_id)->pivot->qtd_real
                "qtd" => $this->actual_pedido->insumos()->where("insumo_id", $this->insumo_id)->where("armazem_id", $this->armazem_id)->sum("qtd_forecast") - $this->actual_pedido->insumos()->where("insumo_id", $this->insumo_id)->where("armazem_id", $this->armazem_id)->sum("qtd_real")
            ]);
        }

        $this->emitSelf("refresh-me");

        $this->clearForm();

        $this->dispatchBrowserEvent("sucesso-salva-entrega");

    }

    public function concluirPedido()
    {
        //mudando o status do pedido
        $this->actual_pedido->update([
            "order_status" => "concluido"
        ]);
        //excluindo algum forecast se ainda existir
        foreach ($this->actual_pedido->insumos as $index => $insumo) {
            if ($this->actual_pedido->details()->where("type", "forecast"))
            {
                $this->actual_pedido->details()->where("type", "forecast")->delete();
            }
        }
        $this->dispatchBrowserEvent("pedido-encerrado");
    }
    
    public function deleteConfirmationEntrega($entrega_id)
    {
        $this->actual_entrega = Entrega::findOrFail($entrega_id);
        $this->dispatchBrowserEvent("confirma-exclusao-entrega");
    }

    public function deleteEntrega()
    {
        //deletando as informações da tabela ENTREGAS
        $this->actual_entrega->delete();
        //atualizando as informações na tabela do PEDIDO
        $this->actual_pedido->insumos()->where("insumo_id", $this->actual_entrega->insumo_id)->where("armazem_id", $this->actual_entrega->armazem_id)->update([
            "qtd_real" => Entrega::where("pedido_id", $this->actual_pedido->id)->where("insumo_id", $this->actual_entrega->insumo_id)->where("armazem_id", $this->actual_entrega->armazem_id)->sum("qtd_delivered")
        ]);
        //atualizando as informações na tabela de DETALHAMENTO
        //excluindo o lançamento real
        $this->actual_pedido->details()->where("insumo_id", $this->actual_entrega->insumo_id)->where("armazem_id", $this->actual_entrega->armazem_id)->where("type", "real")->where("qtd", $this->actual_entrega->qtd_delivered)->delete();
        //atualizando o saldo do lançamento previsto
        if ( ($this->actual_pedido->insumos()->where("insumo_id", $this->actual_entrega->insumo_id)->where("armazem_id", $this->actual_entrega->armazem_id)->sum("qtd_forecast") - $this->actual_pedido->insumos()->where("insumo_id", $this->actual_entrega->insumo_id)->where("armazem_id", $this->actual_entrega->armazem_id)->sum("qtd_real") ) <= 0 ) 
        {
            $this->actual_pedido->details()->where("insumo_id", $this->actual_entrega->insumo_id)->where("armazem_id", $this->actual_entrega->armazem_id)->where("type", "forecast")->delete();
        } else {
            $this->actual_pedido->details()->where("insumo_id",  $this->actual_entrega->insumo_id)->where("armazem_id", $this->actual_entrega->armazem_id)->where("type", "forecast")->update([
                //"qtd" => $this->actual_pedido->insumos->find($this->insumo_id)->pivot->qtd_forecast - $this->actual_pedido->insumos->find($this->insumo_id)->pivot->qtd_real
                "qtd" => $this->actual_pedido->insumos()->where("insumo_id", $this->actual_entrega->insumo_id)->where("armazem_id", $this->actual_entrega->armazem_id)->sum("qtd_forecast") - $this->actual_pedido->insumos()->where("insumo_id", $this->actual_entrega->insumo_id)->where("armazem_id", $this->actual_entrega->armazem_id)->sum("qtd_real")
            ]);
        }

        $this->dispatchBrowserEvent("sucesso-deleta-entrega");
        $this->start();
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
        return view('livewire.pedidos.pedido-list', [
            "pedidos" => Pedido::paginate($this->paginate)
        ]);
    }
}
