<?php

namespace App\Http\Livewire\Pedidos;

use App\Models\Cadastros\Armazem;
use App\Models\Cadastros\Fornecedor;
use App\Models\Cadastros\Insumo;
use App\Models\Cadastros\Usina;
use App\Models\Pedidos\Pedido;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Notifications\PedidoEnviado;
use Illuminate\Support\Facades\Notification;

class PedidoComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['deletePedido'];

    //filter bar
    public $paginate;
    public $search_status;
    public $search_date;

    //variáveis de tabela de PEDIDO
    public $solicitation_date;
    public $usina_id;
    public $fornecedor_id;
    public $tipo_entrega;
    public $order_status;
    public $window_start;
    public $window_finish;
    public $delivery_date;
    public $notes;

    //variáveis da tabela de DETALHAMENTO
    public $user_id;
    public $insumo_id;
    public $armazem_id;
    public $date_report;
    public $document;
    public $type;
    public $category;
    public $moviment_type;
    public $qtd;

    //variáveis auxiliares
    public $form_mode;
    public $usinas;
    public $armazens;
    public $insumos;
    public $fornecedores;
    public $i;
    public $inputs;
    public $actual_pedido;
    public $allPedidos;
    public $data_descarga_item_pedido;

    public function mount()
    {
        $this->start();
    }

    public function start()
    {
 
        //filter bar
        $this->paginate = 5;
        $this->search_armazem = null;
        $this->search_insumo = null;

        //variáveis de tabela PEDIDOS
        $this->solicitation_date = date("Y-m-d", strtotime(now()));
        $this->usina_id = "";
        $this->fornecedor_id = "";
        $this->tipo_entrega = "navio";
        $this->order_status = "analise";
        $this->window_start = "";
        $this->window_finish = "";
        $this->delivery_date = "";
        $this->notes = "";

        //variáveis da tabela DETALHAMENTO
        $this->user_id = Auth::user()->id;
        $this->insumo_id = "";
        $this->armazem_id = "";
        $this->date_report = date("Y-m-d", strtotime($this->delivery_date));
        $this->document = "";
        $this->type = "forecast";
        $this->category = "Entrada Navio";
        $this->moviment_type = "entrada";
        $this->qtd = "";

        //variáveis auxiliares
        $this->form_mode = "create";
        $this->usinas = Usina::all();
        $this->insumos = Insumo::all();
        $this->armazens = Armazem::all();
        $this->fornecedores = Fornecedor::all();
        $this->actual_pedido = null;
        $this->allPedidos = Pedido::all();
        $this->data_descarga_item_pedido = "";
        
        $this->inputs = [];
        $this->i = 1;

    }

    public function resetInputFields()
    {
        $this->insumo_id = "";
        $this->armazem_id = "";
        $this->qtd = "";
    }

    public function add($i)
    {
        $i = $i + 1;
        $this->i = $i;
        array_push($this->inputs, $i);
    }

    public function remove($i)
    {
        unset($this->inputs[$i]);
    }

    public function createPedido()
    {
        $customMessages = [
            'solicitation_date.required'  => '✋ Campo obrigatório!',
            'usina_id.required'  => '✋ Campo obrigatório!',
            'fornecedor_id.required'  => '✋ Campo obrigatório!',
            'tipo_entrega.required'  => '✋ Falta este!',
            'window_start.required'  => '✋ Campo obrigatório!',
            'window_finish.required'  => '✋ Campo obrigatório!',
            'delivery_date.required'  => '✋ Campo obrigatório!',
            'insumo_id.0.required'  => '✋ Campo obrigatório!',
            'armazem_id.0.required'  => '✋ Campo obrigatório!',
            'qtd.0.required'  => '✋ Campo obrigatório!',
            'insumo_id.*.required'  => '✋ Campo obrigatório!',
            'armazem_id.*.required'  => '✋ Campo obrigatório!',
            'qtd.*.required'  => '✋ Campo obrigatório!'
        ];

        if ($this->tipo_entrega === "navio") {
            $this->validate([
                'solicitation_date' => 'required|date',
                'usina_id' => "required",
                'fornecedor_id' => "required",
                'tipo_entrega' => 'required',
                'window_start' => "required|date",
                'window_finish' => "required|date",
                'insumo_id.0' => "required",
                'armazem_id.0' => "required",
                'qtd.0' => "required",
                'insumo_id.*' => "required",
                'armazem_id.*' => "required",
                'qtd.*' => "required"
            ], $customMessages);
        } else {
            $this->validate([
                'solicitation_date' => 'required|date',
                'fornecedor_id' => "required",
                'tipo_entrega' => 'required',
                'delivery_date' => 'required|date',
                'insumo_id.0' => "required",
                'armazem_id.0' => "required",
                'qtd.0' => "required",
                'insumo_id.*' => "required",
                'armazem_id.*' => "required",
                'qtd.*' => "required"
            ], $customMessages);
        }
        
        //criando o pedido
        $pedido = new Pedido();
        $pedido->solicitation_date = date("Y-m-d", strtotime($this->solicitation_date));
        $pedido->usina_id = $this->tipo_entrega === "navio" ? $this->usina_id : null;
        $pedido->fornecedor_id = $this->fornecedor_id;
        $pedido->tipo_entrega = $this->tipo_entrega;
        $pedido->order_status = $this->tipo_entrega === "navio" ? $this->order_status : "concluido";
        $pedido->window_start = $this->tipo_entrega === "navio" ? date("Y-m-d", strtotime($this->window_start)) : null;
        $pedido->window_finish = $this->tipo_entrega === "navio" ? date("Y-m-d", strtotime($this->window_finish)) : null;
        $pedido->delivery_date = $this->tipo_entrega === "navio" ? date("Y-m-d", strtotime($this->window_finish)) : date("Y-m-d", strtotime($this->delivery_date));
        $pedido->document = $this->document;
        $pedido->notes = $this->notes;
        $pedido->save();

        if ($this->tipo_entrega === "navio") {
            //caso a entrega seja feita via navio, só há a previsão
            foreach ($this->insumo_id as $key => $value) {
                $pedido->insumos()->attach($this->insumo_id[$key], [
                    "armazem_id" => $this->armazem_id[$key],
                    "qtd_forecast" => $this->qtd[$key],
                    "qtd_real" => 0,
                    "data_descarga_item_pedido" => date("Y-m-d", strtotime($this->window_finish))
                ]);
            }
        } else {
            //caso a entrega seja por transferência, haverá a qtde previsata e real, além da data da entrega
            foreach ($this->insumo_id as $key => $value) {
                $pedido->insumos()->attach($this->insumo_id[$key], [
                    "armazem_id" => $this->armazem_id[$key],
                    "qtd_forecast" => $this->qtd[$key],
                    "qtd_real" => $this->qtd[$key],
                    "data_descarga_item_pedido" => date("Y-m-d", strtotime($this->delivery_date))
                ]);
            }
        }

        if ($this->tipo_entrega === "transferencia") {
            foreach ($this->insumo_id as $key => $value)
            {
            $pedido->details()->create([
                'user_id' => $this->user_id,
                'insumo_id' => $this->insumo_id[$key],
                'armazem_id' => $this->armazem_id[$key],
                'date_report' => $pedido->delivery_date,
                'document' => $this->document,
                'type' => "real",
                'category' => $this->category,
                'moviment_type' => $this->moviment_type,
                'qtd' => $this->qtd[$key]
            ]);
            }
        }

        $this->dispatchBrowserEvent("sucesso-salva-pedido");

        //notificando os demais usuários do sistema sobre a criação do pedido
        $user = User::findOrFail(Auth::user()->id);
        $allUsers = User::all();

        Notification::send($allUsers, new PedidoEnviado($user, $pedido));

        $this->start(); 
        $this->resetInputFields();  

    }
    
    public function deleteConfirmationPedido($id)
    {
        $this->actual_pedido = Pedido::findOrFail($id);
        $this->dispatchBrowserEvent("confirma-exclusao-pedido");
    }

    public function deletePedido()
    {
        $pedido = Pedido::findOrFail($this->actual_pedido->id);
        foreach ($pedido->details as $key => $detalhe) {
            $detalhe->delete();
        }
        $pedido->delete();
        $pedido->insumos()->detach();
        
        $this->dispatchBrowserEvent("sucesso-deleta-pedido");
        $this->start();
    }

    public function cancel()
    {
        $this->start();
        $this->resetInputFields();
    }

    public function render()
    {
        return view('livewire.pedidos.pedido-component', [
            "pedidos" => Pedido::with("details")->with("insumos")
                        ->when($this->search_status, function($query){
                                    $query->where('order_status', $this->search_status);
                        })
                        ->when($this->search_date, function($query){
                            $query->where('delivery_date', $this->search_date);
                        })
                        ->paginate($this->paginate),
        ]);
    }
}
