<?php

namespace App\Http\Livewire\Pedidos;

use App\Models\Cadastros\Armazem;
use App\Models\Cadastros\Fornecedor;
use App\Models\Cadastros\Insumo;
use App\Models\Cadastros\Usina;
use App\Models\Pedidos\Pedido;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PedidoEdit extends Component
{
    protected $listeners = ["update" => "render", "deleteInsumo", "deletePedido"];
    //pedido a ser editado
    public $pedido;

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
    //public $category;
    //public $moviment_type;
    public $qtd;
    
    //variáveis auxiliares
    public $fornecedores;
    public $usinas;
    public $armazens;
    public $insumos;
    public $qtd_forecast;
    public $qtd_real;
    public $data_descarga_item_pedido;
    public $form_mode;
    public $actual_insumo;


    public function mount($pedido)
    {
        $this->pedido = $pedido;
        $this->start();

    }

    public function start()
    {
        //variáveis de tabela de PEDIDO
        $this->solicitation_date = date("Y-m-d", strtotime($this->pedido->solicitation_date));
        $this->usina_id = $this->pedido->usina_id;
        $this->fornecedor_id = $this->pedido->fornecedor_id;
        $this->tipo_entrega = $this->pedido->tipo_entrega;
        $this->order_status = $this->pedido->order_status;
        $this->window_start = date("Y-m-d", strtotime($this->pedido->window_start));
        $this->window_finish = date("Y-m-d", strtotime($this->pedido->window_finish));
        $this->delivery_date = $this->pedido->delivery_date;
        $this->notes = $this->pedido->notes;

        //variáveis da tabela de DETALHAMENTO
        $this->user_id = $this->pedido->details->count() > 0 ? User::findOrFail($this->pedido->details->first()->user_id) : User::findOrFail(Auth::user()->id);
        $this->insumo_id = "";
        //$this->armazem_id = $this->pedido->armazem_id;
        $this->document = $this->pedido->details->count() > 0 ? $this->pedido->details->first()->document : $this->pedido->document;
        $this->type = $this->pedido->details->count() > 0 ? $this->pedido->details->first()->type : "forecast";
        $this->category = $this->pedido->details->count() > 0 ? $this->pedido->details->first()->category : "Entrada Navio";
        $this->moviment_type = "entrada";
        $this->qtd = "";

        //variáveis auxiliares
        $this->fornecedores = Fornecedor::all();
        $this->usinas = Usina::all();
        $this->armazens = Armazem::all();
        $this->insumos = Insumo::all();
        $this->form_mode = "create";
        $this->qtd_forecast = "";
        $this->qtd_real = "";
        $this->data_descarga_item_pedido = "";

    }


    public function updatePedido()
    {
        $customMessages = [
            'solicitation_date.required'  => '✋ Campo obrigatório!',
            'usina_id.required'  => '✋ Campo obrigatório!',
            'fornecedor_id.required'  => '✋ Campo obrigatório!',
            'tipo_entrega.required'  => '✋ Falta este!',
            'solicitation_date.required'  => '✋ Campo obrigatório!',
            'window_start.required'  => '✋ Campo obrigatório!',
            'window_finish.required'  => '✋ Campo obrigatório!',
        ];

        $this->validate([
            'solicitation_date' => 'required|date',
            'usina_id' => "required",
            'fornecedor_id' => "required",
            'tipo_entrega' => 'required',
            'solicitation_date' => "required|date",
            'window_start' => "required|date",
            'window_finish' => "required|date"
        ], $customMessages);

        $pedido = Pedido::with("insumos")->findOrFail($this->pedido->id);

        //atualizando tabela PEDIDO
        $pedido->solicitation_date = date("Y-m-d", strtotime($this->solicitation_date));
        $pedido->usina_id = $this->usina_id;
        $pedido->fornecedor_id = $this->fornecedor_id;
        $pedido->tipo_entrega = $this->tipo_entrega;
        $pedido->order_status = $this->order_status;
        $pedido->window_start = date("Y-m-d", strtotime($this->window_start));
        $pedido->window_finish = date("Y-m-d", strtotime($this->window_finish));
        $pedido->delivery_date = $this->tipo_entrega === "navio" ? date("Y-m-d", strtotime($this->window_finish)) : date("Y-m-d", strtotime($this->delivery_date));
        $pedido->notes = $this->notes;
        $pedido->update();

        if ($this->order_status === "analise")
        {
            $this->type = "forecast";
        }
        elseif($this->order_status === "aprovado")
        {
            $this->type = "forecast";
        }
        elseif($this->order_status === "reprovado")
        {
            $this->type = "canceled";
        }
        else
        {
            $this->type = "real";
        }

        if ($this->order_status === "aprovado") {
           foreach ($this->pedido->insumos as $index => $insumo) {
               $this->pedido->details()->updateOrCreate(
                   ["detail_id" => $this->pedido->id, "insumo_id" => $insumo->id, "armazem_id" => $insumo->armazem_id],
                   [
                    'user_id' => $this->user_id->id,
                    'insumo_id' => $insumo->id,
                    'armazem_id' => $insumo->pivot->armazem_id,
                    //'date_report' => date("Y-m-d", strtotime($this->window_finish)),
                    'date_report' => date("Y-m-d", strtotime($insumo->pivot->data_descarga_item_pedido)),
                    'document' => $this->document,
                    'type' => $this->type,
                    'category' => $this->category,
                    'moviment_type' => $this->moviment_type,
                    'qtd' => $insumo->pivot->qtd_forecast
                   ]
                );
           }
        }

        if ($this->order_status === "analise" && $this->pedido->details->count() > 0)
        {
            foreach ($this->pedido->details as $key => $item) {
               $item->delete();
            }
           
        }
        
        //atualizando a tabela de DETALHAMENTO
        /*
        $pedido->details()->update([
            "document" => $this->document,
            "armazem_id" => $this->armazem_id,
            "date_report" => $this->delivery_date,
            "type" => $this->type
        ]);
        */

        $this->dispatchBrowserEvent("sucesso-edita-pedido");
       
        $this->emit("update");
        $this->mount($pedido);

    }

    public function inserirInsumo()
    {
        $customMessages = [
            'insumo_id.required'  => '✋ Campo obrigatório!',
            'armazem_id.required'  => '✋ Campo obrigatório!',
            'qtd_forecast.required'  => '✋ Campo obrigatório!',
            'data_descarga_item_pedido.required'  => '✋ Campo obrigatório!',
            'data_descarga_item_pedido.date'  => '✋ Formato inválido!',
        ];

        $this->validate([
            'insumo_id' => 'required',
            'armazem_id' => 'required',
            'qtd_forecast' => "required|numeric",
            'data_descarga_item_pedido' => "required|date"
        ], $customMessages);

        //atualizando a tabela pivô
        $this->pedido->insumos()->attach($this->insumo_id, [
            "armazem_id" => $this->armazem_id,
            "qtd_forecast" => $this->qtd_forecast === "" ? 0 : $this->qtd_forecast,
            "qtd_real" => 0,
            "data_descarga_item_pedido" => $this->data_descarga_item_pedido,
        ]);

        //excluindo caso haja algum detalhamento e o status do pedido seja em análise
        if ($this->order_status === "analise" && $this->pedido->details->count() > 0)
        {
            foreach ($this->pedido->details as $key => $item) {
               $item->delete();
            }
           
        }

        if ($this->order_status === "aprovado") {
            //atualizando o detalhamento
            $this->pedido->details()->create([
                'user_id' => $this->user_id->id,
                'insumo_id' => $this->insumo_id,
                'armazem_id' => $this->armazem_id,
                'date_report' => date("Y-m-d", strtotime($this->data_descarga_item_pedido)),
                'document' => $this->document,
                'type' => $this->type,
                'category' => "Entrada Navio",
                'moviment_type' => "entrada",
                'qtd' => $this->qtd_forecast
            ]);
         }

        $this->dispatchBrowserEvent("sucesso-edita-pedido");

        $this->start();
        $this->emit("update");
        $this->clearForm();
    }

    public function showEditForm($insumo_id, $armazem_id)
    {

        $this->form_mode = "edit";
        $this->actual_insumo = $this->pedido->insumos->where("pivot.insumo_id", $insumo_id)->where("pivot.armazem_id", $armazem_id)->toArray();
        /*
        $this->insumo_id = $this->actual_insumo->id;
        $this->armazem_id = $this->actual_insumo->pivot->armazem_id;
        $this->data_descarga_item_pedido = $this->actual_insumo->pivot->data_descarga_item_pedido;
        $this->qtd_forecast = $this->actual_insumo->pivot->qtd_forecast;
        $this->qtd_real = $this->actual_insumo->pivot->qtd_real;
        */
        $this->insumo_id = array_values($this->actual_insumo)[0]["pivot"]["insumo_id"];
        $this->armazem_id = array_values($this->actual_insumo)[0]["pivot"]["armazem_id"];
        $this->data_descarga_item_pedido = array_values($this->actual_insumo)[0]["pivot"]["data_descarga_item_pedido"] === null ? date("Y-m-d", strtotime(now())) : date("Y-m-d", strtotime(array_values($this->actual_insumo)[0]["pivot"]["data_descarga_item_pedido"]));
        $this->qtd_forecast = array_values($this->actual_insumo)[0]["pivot"]["qtd_forecast"];
        $this->qtd_real = array_values($this->actual_insumo)[0]["pivot"]["qtd_real"];
    }

    public function editItem()
    {
        //$this->pedido->insumos()->find($this->actual_insumo->id)->pivot->update([
        $this->pedido->insumos()->where("insumo_id", array_values($this->actual_insumo)[0]["pivot"]["insumo_id"])->where("armazem_id", array_values($this->actual_insumo)[0]["pivot"]["armazem_id"])->update([
            "insumo_id" => $this->insumo_id,
            "armazem_id" => $this->armazem_id,
            "qtd_forecast" => $this->qtd_forecast,
            "qtd_real" => $this->qtd_real,
            "data_descarga_item_pedido" => date("Y-m-d", strtotime($this->data_descarga_item_pedido)),
        ]);

        if ($this->order_status === "aprovado") {
            $this->pedido->details()->where("insumo_id", array_values($this->actual_insumo)[0]["pivot"]["insumo_id"])->where("armazem_id", array_values($this->actual_insumo)[0]["pivot"]["armazem_id"])->update([
                'user_id' => $this->user_id->id,
                'insumo_id' => $this->insumo_id,
                'armazem_id' => $this->armazem_id,
                'qtd' => $this->qtd_forecast,
                'date_report' => date("Y-m-d", strtotime($this->data_descarga_item_pedido)),
            ]);
        }

        $this->dispatchBrowserEvent("sucesso-edita-pedido");
        $this->start();
        $this->emit("update");
        $this->clearForm();
    }

    public function clearForm()
    {
        $this->form_mode = "create";
        $this->insumo_id = "";
        $this->armazem_id = "";
        $this->qtd_forecast = "";
        $this->qtd_real = "";
    }

    public function deleteConfirmationInsumo($id)
    {
        $this->actual_insumo = $this->pedido->insumos->find($id);
        $this->dispatchBrowserEvent("confirma-exclusao-insumo");
    }

    public function deleteInsumo()
    {
        $this->pedido->insumos()->detach($this->actual_insumo->id);
        $this->pedido->details()->where("insumo_id", $this->actual_insumo->id)->delete();
        $this->dispatchBrowserEvent("sucesso-deleta-insumo");
        $this->start();
        $this->emit("update");
    }

    public function deleteConfirmationPedido()
    {

        $this->dispatchBrowserEvent("confirma-exclusao-pedido");
    }

    public function deletePedido()
    {
        foreach ($this->pedido->details as $key => $detalhe) {
            $detalhe->delete();
        }
        $this->pedido->delete();
        $this->pedido->insumos()->detach();
        
        
        $this->dispatchBrowserEvent("sucesso-deleta-pedido");
        $this->redirect(route('pedidos.index'));
    }

    public function render()
    {      
        return view('livewire.pedidos.pedido-edit');
    }
}
