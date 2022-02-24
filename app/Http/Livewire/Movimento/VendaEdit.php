<?php

namespace App\Http\Livewire\Movimento;

use App\Models\Cadastros\Armazem;
use App\Models\Cadastros\Cliente;
use App\Models\Cadastros\Produto;
use App\Models\Pedidos\Entrega;
use App\Models\Vendas\Delivery;
use App\Models\Vendas\Venda;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class VendaEdit extends Component
{
    protected $listeners = [
        'refresh-me' => '$refresh',
        'deleteProduto',
        'deleteVenda',
        'deleteEntrega',
        'encerraVenda'
    ];

    public $venda;

    //variáveis auxiliares
    public $form_mode;
    public $clientes;
    public $produtos;
    public $armazens;

    //variáveis da tabela de VENDA
    public $sale_date;
    public $mode;   //venda normal, antecipação ou mudança de propriedade
    public $cliente_id;
    public $retirada;
    public $notes;

    //variáveis da tabela PRODUTO_VENDA
    public $produto_id;
    public $qtd_sale;
    //public $armazem_id;
    public $detail_type;
    public $qtd_delivered;
    public $date_retirada;

    //variáveis da tabela de DETALHAMENTO
    public $user_id;
    public $insumo_id;
    public $armazem_id;
    public $product_id;
    public $date_report;
    public $document;
    public $type;
    public $category;
    public $moviment_type;
    public $qtd;


    public function mount($venda)
    {
        $this->venda = $venda;
        $this->start();
    }

    public function start()
    {
        //variáveis auxiliares
        $this->form_mode = "create";
        $this->clientes = Cliente::all();
        $this->produtos = Produto::all();
        $this->armazens = Armazem::all();

        $this->produto_escolhido = null;
        $this->armazem_escolhido = null;

        //variáveis da tabela de VENDA
        $this->sale_date = $this->venda->sale_date;
        $this->mode = $this->venda->mode;
        $this->cliente_id = $this->venda->cliente_id;
        $this->retirada = $this->venda->retirada;
        $this->notes = $this->venda->notes;

        //variáveis da tabela de DETALHAMENTO
        //$this->user_id;
        //$this->insumo_id;
        //$this->armazem_id = '';
        //$this->date_report = $this->venda->details()->first()->date_report;
        $this->document = $this->venda->details()->first()->document;
        $this->type = $this->venda->details()->first()->type;
        $this->category = "Venda";
        $this->moviment_type = "saida";
        //$this->qtd;
        $this->clearForm();

        $this->clearFormDelivery();


    }

    public function updateVenda()
    {
        $customMessages = [
            'sale_date.required'  => '✋ Campo obrigatório!',
            'cliente_id.required'  => '✋ Campo obrigatório!',
        ];

        $this->validate([
            'sale_date' => 'required|date',
            'cliente_id' => 'required',
        ], $customMessages);

        //atualizando dados da tabela de VENDA
        $this->venda->sale_date = date("Y-m-d", strtotime($this->sale_date));
        $this->venda->cliente_id = $this->cliente_id;
        //$this->venda->retirada = date("Y-m-d", strtotime($this->date_report));
        $this->venda->notes = $this->notes;
        $this->venda->update();

        //atualizando dados da tabela de DETALHAMENTO
        foreach ($this->venda->produtos as $index => $produto) {
            foreach ($produto->insumos as $key => $insumo) {
                $this->venda->details()->where("category", "Venda")->where("insumo_id", $insumo->id)->where("armazem_id", $produto->pivot->armazem_id)->update([
                    //"type" => $this->type,
                    //"armazem_id" => $this->armazem_id,
                    //"date_report" => date("Y-m-d", strtotime($this->date_report)),
                    "document" => $this->document
                ]);
            }
        }

        $this->dispatchBrowserEvent("venda-atualizada");
    }

    public $produto_escolhido;
    public $armazem_escolhido;

    public function showEditForm($product_id, $armazem_id)
    {
        $this->produto_escolhido = Produto::findOrFail($product_id);
        $this->armazem_escolhido = Armazem::findOrFail($armazem_id);
        $venda = array_values($this->venda->produtos->where("pivot.produto_id", $product_id)->where("pivot.armazem_id", $armazem_id)->toArray());
        $this->form_mode = "edit";
        //exibindo as informações no formulário de edição
        $this->produto_id = $venda[0]["pivot"]["produto_id"];
        $this->armazem_id = $venda[0]["pivot"]["armazem_id"];
        $this->date_report = date("Y-m-d", strtotime($venda[0]["pivot"]["date_retirada"]));
        $this->qtd_sale = $venda[0]["pivot"]["qtd_sale"];
    }

    public function updateProduto()
    {
        //dd($this->venda->produtos->find($this->produto_escolhido->id)->pivot->uniq_code);
        $customMessages = [
            'produto_id.required'  => '✋ Campo obrigatório!',
            'armazem_id.required'  => '✋ Campo obrigatório!',
            'date_report.required'  => '✋ Campo obrigatório!',
            'date_report.date'  => '✋ Formato inválido!',
            'qtd_sale.required'  => '✋ Campo obrigatório!',
            'qtd_sale.numeric'  => '✋ Formato inválido!',
        ];

        $this->validate([
            'produto_id' => 'required',
            'armazem_id' => 'required',
            'date_report' => 'required|date',
            'qtd_sale' => 'required|numeric',
        ], $customMessages);
        
        //atualizando a tabela de PRODUTO_VENDA
        //$this->venda->produtos()->where("produto_id", $this->produto_escolhido->id)->where("armazem_id", $this->armazem_escolhido->id)->update([
        $this->venda->produtos()->where("uniq_code", $this->venda->produtos->find($this->produto_escolhido->id)->pivot->uniq_code)->update([
            "produto_id" => $this->produto_id,
            "qtd_sale" => $this->qtd_sale,
            "armazem_id" => $this->armazem_id,
            "detail_type" => $this->venda->mode === "antecipacao" ? "antecipacao" : "normal",
            //"qtd_delivered" => $this->venda->mode != "antecipacao" ? $this->qtd_sale : 0,
            "date_retirada" => date("Y-m-d", strtotime($this->date_report))
        ]);

        //atualizando a tabela de detalhamento
        if ($this->produto_escolhido->id === $this->produto_id) {
            foreach ($this->produto_escolhido->insumos as $index => $insumo)
            {
                //$this->venda->details()->where("category", "Venda")->where("insumo_id", $insumo->id)->where("armazem_id", $this->armazem_escolhido->id)->where("product_id", $this->produto_escolhido->id)->update([
                $this->venda->details()->where("uniq_code", $this->venda->produtos->find($this->produto_escolhido->id)->pivot->uniq_code)->where("insumo_id", $insumo->id)->where("armazem_id", $this->armazem_escolhido->id)->update([
                    'user_id' => Auth::user()->id,
                    'insumo_id' => $insumo->id,
                    //'product_id' => $this->produto_escolhido->id,
                    'armazem_id' => $this->armazem_id,
                    'date_report' => date("Y-m-d", strtotime($this->date_report)),
                    //'document' => $this->document,
                    //'type' => $this->type,
                    //'category' => $this->category,
                    //'moviment_type' => $this->moviment_type,
                    'qtd' => -($this->qtd_sale * (($insumo->pivot->percent)/100))
                ]);
            }
        } else {
            $this->venda->details()->where("category", "Venda")->where("armazem_id", $this->armazem_escolhido->id)->where("product_id", $this->produto_escolhido->id)->delete();
            $new_produto = Produto::findOrFail($this->produto_id);
            foreach ($new_produto->insumos as $index => $insumo) {
                $this->venda->details()->create([
                    'user_id' => Auth::user()->id,
                    'insumo_id' => $insumo->id,
                    'product_id' => $new_produto->id,
                    'uniq_code' => $this->venda->produtos->find($this->produto_escolhido->id)->pivot->uniq_code,
                    'armazem_id' => $this->armazem_id,
                    'date_report' => date("Y-m-d", strtotime($this->date_report)),
                    'document' => null,
                    'type' => "real",
                    'category' => "Venda",
                    'moviment_type' => "saida",
                    'qtd' => -($this->venda->produtos()->find($new_produto->id)->pivot->qtd_sale * (($insumo->pivot->percent)/100))
                ]);
            }
        }
        
    
        $this->emitSelf("refresh-me");
        $this->dispatchBrowserEvent("venda-atualizada");
        $this->start();
    }

    public function clearForm()
    {
        $this->form_mode = "create";
        $this->produto_id = "";
        $this->armazem_id = "";
        $this->date_report = "";
        $this->qtd_sale = "";
        $this->actual_product = null;
        $this->actual_armazem = null;
    }

    public function inserirProduto()
    {
        $customMessages = [
            'produto_id.required'  => '✋ Campo obrigatório!',
            'armazem_id.required'  => '✋ Campo obrigatório!',
            'date_report.required'  => '✋ Campo obrigatório!',
            'date_report.date'  => '✋ Formato inválido!',
            'qtd_sale.required'  => '✋ Campo obrigatório!',
            'qtd_sale.numeric'  => '✋ Formato inválido!',
        ];

        $this->validate([
            'produto_id' => 'required',
            'armazem_id' => 'required',
            'date_report' => 'required|date',
            'qtd_sale' => 'required|numeric',
        ], $customMessages);

        //atualizando a tabela PRODUTO VENDA
        $this->venda->produtos()->attach( $this->produto_id, [
            "qtd_sale" => $this->qtd_sale,
            "armazem_id" => $this->armazem_id,
            "detail_type" => $this->venda->mode === "antecipacao" ? "antecipacao" : "normal",
            "qtd_delivered" => $this->venda->mode != "antecipacao" ? $this->qtd_sale : 0,
            "date_retirada" => date("Y-m-d", strtotime($this->date_report))
        ]);
        //atualizando a tabela de detalhes
        $produto = Produto::findOrFail($this->produto_id);
        foreach ($produto->insumos as $key => $insumo) {
            $this->venda->details()->create([
                'user_id' => Auth::user()->id,
                'insumo_id' => $insumo->pivot->insumo_id,
                'armazem_id' => $this->armazem_id,
                'product_id' => $produto->id,
                'date_report' => date("Y-m-d", strtotime($this->date_report)),
                'document' => null,
                'type' => "real",
                'category' => "Venda",
                'moviment_type' => "saida",
                'qtd' => -($this->qtd_sale * (($insumo->pivot->percent)/100))
            ]);
        }


        $this->emitSelf("refresh-me");
        $this->dispatchBrowserEvent("produto-inserido");
        $this->start();
    }

    public function deleteConfirmationProduto($produto_id, $armazem_id)
    {
        $this->produto_escolhido = Produto::findOrFail($produto_id);
        $this->armazem_escolhido = Armazem::findOrFail($armazem_id);
        $this->dispatchBrowserEvent("confirma-exclusao-produto");
    }

    public function deleteProduto()
    {
        //excluindo da tabela de PRODUTO VENDA
        $this->venda->produtos()->detach($this->produto_escolhido->id);
        //excluindo da tabela de DETALHAMENTO
        foreach ($this->produto_escolhido->insumos as $key => $insumo) {
            $this->venda->details()->where("product_id", $this->produto_escolhido->id)->where("insumo_id", $insumo->id)->where("armazem_id", $this->armazem_escolhido->id)->delete();
        }
        //excluindo as entregas que houver
        foreach ($this->venda->entregas as $key => $entrega) {
            $this->venda->entregas()->where("entrega_produto_id", $this->produto_escolhido->id)->where("entrega_armazem_id", $this->armazem_escolhido->id)->delete();
        }
        $this->emitSelf("refresh-me");
        $this->dispatchBrowserEvent("produto-deletado");
        $this->start();
    }

    public function deleteConfirmationVenda()
    {
        $this->dispatchBrowserEvent("confirma-exclusao-venda");
    }

    public function deleteVenda()
    {

        foreach ($this->venda->details as $key => $detalhe) {
            $detalhe->delete();
        }
        $this->venda->delete();
        
        $this->dispatchBrowserEvent("sucesso-deleta-venda");
        redirect()->route('vendas.index');
    }

    //variáveis da tabela ENTREGA
    public $entrega_produto_id;
    public $entrega_armazem_id;
    public $entrega_delivery_date;
    public $entrega_qtd_delivered;

    /****** ENTREGAS  */
    public function novaEntrega()
    {
        $customMessages = [
            'entrega_produto_id.required'  => '✋ Campo obrigatório!',
            'entrega_armazem_id.required'  => '✋ Campo obrigatório!',
            'entrega_delivery_date.required'  => '✋ Campo obrigatório!',
            'entrega_delivery_date.date'  => '✋ Formato inválido!',
            'entrega_qtd_delivered.required'  => '✋ Campo obrigatório!',
            'entrega_qtd_delivered.numeric'  => '✋ Formato inválido!',
        ];

        $this->validate([
            'entrega_produto_id' => 'required',
            'entrega_armazem_id' => 'required',
            'entrega_delivery_date' => 'required|date',
            'entrega_qtd_delivered' => 'required|numeric',
        ], $customMessages);

        $uniq_code = md5(uniqid(rand(), true));

        //adicionando a entrega na tabela VENDA ENTREGA
        $this->venda->entregas()->create([
            "uniq_code" =>  $uniq_code,
            "entrega_produto_id" => $this->entrega_produto_id,
            "entrega_armazem_id" => $this->entrega_armazem_id,
            "entrega_delivery_date" => $this->entrega_delivery_date,
            "entrega_qtd_delivered" => $this->entrega_qtd_delivered
        ]);

        //atualizando o saldo da tabela PRODUTO_VENDA
        foreach ($this->venda->produtos as $key => $produto) {
            if ($produto->id == $this->entrega_produto_id && $produto->pivot->armazem_id == $this->entrega_armazem_id) {
                $this->venda->produtos()->where("produto_id", $this->entrega_produto_id)->where("armazem_id", $this->entrega_armazem_id)->update([
                    "qtd_delivered" => Delivery::where("venda_id", $this->venda->id)->where("entrega_produto_id", $this->entrega_produto_id)->where("entrega_armazem_id", $this->entrega_armazem_id)->sum("entrega_qtd_delivered")
                ]);
            }
        }

        //atualizando a tabela DETALHAMENTO
        $produto = Produto::findOrFail($this->entrega_produto_id);
        foreach ($produto->insumos as $key => $insumo) {
            $this->venda->details()->create([
                'user_id' => Auth::user()->id,
                'insumo_id' => $insumo->pivot->insumo_id,
                'armazem_id' => $this->entrega_armazem_id,
                'product_id' => $produto->id,
                'uniq_code' => $uniq_code,
                'date_report' => date("Y-m-d", strtotime($this->entrega_delivery_date)),
                'document' => null,
                'type' => "real",
                'category' => "Venda",
                'moviment_type' => "saida",
                'qtd' => -($this->entrega_qtd_delivered * (($insumo->pivot->percent)/100))
            ]);
        }

        $this->emitSelf("refresh-me");
        $this->dispatchBrowserEvent("nova-entrega");
        $this->start();
    }

    public $form_delivery;

    public $entrega_escolhida;

    public function clearFormDelivery()
    {
        $this->form_delivery = "create";
        $this->entrega_escolhida = null;

        $this->entrega_produto_id = '';
        $this->entrega_armazem_id = '';
        $this->entrega_delivery_date = '';
        $this->entrega_qtd_delivered = '';
    }


    public function showEditFormDelivery($delivery_id)
    {
        $this->form_delivery = "edit";
        $this->entrega_escolhida = Delivery::findOrFail($delivery_id);
        $this->entrega_produto_id = $this->entrega_escolhida->entrega_produto_id;
        $this->entrega_armazem_id = $this->entrega_escolhida->entrega_armazem_id;
        $this->entrega_delivery_date = date("Y-m-d", strtotime($this->entrega_escolhida->entrega_delivery_date));
        $this->entrega_qtd_delivered = $this->entrega_escolhida->entrega_qtd_delivered;
    }

    public function updateEntrega()
    {
        $customMessages = [
            'entrega_produto_id.required'  => '✋ Campo obrigatório!',
            'entrega_armazem_id.required'  => '✋ Campo obrigatório!',
            'entrega_delivery_date.required'  => '✋ Campo obrigatório!',
            'entrega_delivery_date.date'  => '✋ Formato inválido!',
            'entrega_qtd_delivered.required'  => '✋ Campo obrigatório!',
            'entrega_qtd_delivered.numeric'  => '✋ Formato inválido!',
        ];

        $this->validate([
            'entrega_produto_id' => 'required',
            'entrega_armazem_id' => 'required',
            'entrega_delivery_date' => 'required|date',
            'entrega_qtd_delivered' => 'required|numeric',
        ], $customMessages);

        //atualizando o saldo na tabela PRODUTO VENDA
        $this->venda->entregas()->where("uniq_code", $this->entrega_escolhida->uniq_code)->update([
            "entrega_produto_id" => $this->entrega_produto_id,
            "entrega_armazem_id" => $this->entrega_armazem_id,
            "entrega_delivery_date" => date("Y-m-d", strtotime($this->entrega_delivery_date)),
            "entrega_qtd_delivered" => $this->entrega_qtd_delivered
        ]);

        $this->venda->produtos()->where("produto_id", $this->entrega_escolhida->entrega_produto_id)->where("armazem_id", $this->entrega_escolhida->entrega_armazem_id)->update(
            [
                "produto_id" => $this->entrega_produto_id,
                "armazem_id" => $this->entrega_armazem_id,
                "detail_type" => "antecipacao",
                //"qtd_sale" => 0,
                "qtd_delivered" => Delivery::where("venda_id", $this->venda->id)->where("entrega_produto_id", $this->entrega_produto_id)->where("entrega_armazem_id", $this->entrega_armazem_id)->sum("entrega_qtd_delivered")
            ]
        );

        //atualizando as informações da tabela de DETALHAMENTO        
         $produto = Produto::findOrFail($this->entrega_produto_id);
         if ($this->entrega_escolhida->entrega_produto_id === $this->entrega_produto_id) 
         {
            # somente atualização da tabela detalhamento
            foreach ($produto->insumos as $key => $insumo)
            {
                $this->venda->details()->where("uniq_code", $this->entrega_escolhida->uniq_code)->where("category", "Venda")->where("insumo_id", $insumo->id)->where("armazem_id", $this->entrega_armazem_id)->where("product_id", $produto->id)->where("type", "real")->update([
                    'user_id' => Auth::user()->id,
                    'insumo_id' => $insumo->id,
                    'product_id' => $produto->id,
                    'armazem_id' => $this->entrega_armazem_id,
                    'date_report' => date("Y-m-d", strtotime($this->entrega_delivery_date)),
                    'document' => null,
                    //'type' => $this->type,
                    //'category' => $this->category,
                    //'moviment_type' => $this->moviment_type,
                    'qtd' => -($this->entrega_qtd_delivered * (($insumo->pivot->percent)/100))
                ]);
            }

            $this->atualizaSaldo($this->entrega_produto_id);

         } 
         else 
         {
             # exclusão do antigo registro e inclusão do novo
             $this->venda->details()->where("category", "Venda")->where("armazem_id", $this->entrega_escolhida->entrega_armazem_id)->where("product_id", $this->entrega_escolhida->entrega_produto_id)->delete();
             # atualizando a tabela de detalhamento
             foreach ($produto->insumos as $index => $insumo)
             {
                $this->venda->details()->create([
                    'user_id' => Auth::user()->id,
                    'insumo_id' => $insumo->id,
                    'product_id' => $produto->id,
                    'uniq_code' => $this->entrega_escolhida->uniq_code,
                    'armazem_id' => $this->entrega_armazem_id,
                    'date_report' =>date("Y-m-d", strtotime($this->entrega_delivery_date)),
                    'document' => null,
                    'type' => "real",
                    'category' => "Venda",
                    'moviment_type' => "saida",
                    'qtd' => -($this->entrega_qtd_delivered  * (($insumo->pivot->percent)/100))
                ]);
            }
         }

        $this->emitSelf("refresh-me");
        $this->dispatchBrowserEvent("entrega-editada");
        
        $this->start();

    }

    public function atualizaSaldo($produto_id)
    {
        $produto = Produto::findOrFail($produto_id);
        //do previsto da tabela de DETALHAMENTO
        if ( ($this->venda->produtos->find($produto->id)->pivot->qtd_sale - $this->venda->produtos->find($produto->id)->pivot->qtd_delivered) <= 0) 
        {
            /*
            foreach ($this->venda->details as $key => $detalhe) {
                $detalhe->where("uniq_code", $this->venda->produtos->find($produto->id)->pivot->uniq_code)->delete();
            }
            */
            $this->venda->details()->where("uniq_code", $this->venda->produtos->find($produto->id)->pivot->uniq_code)->delete();
            
        } 
        else 
        {
            foreach ($produto->insumos as $key => $insumo)
            {
                $this->venda->details()->where("uniq_code", $this->venda->produtos->find($produto->id)->pivot->uniq_code)->where("category", "Venda")->where("insumo_id", $insumo->id)->where("armazem_id", $this->entrega_armazem_id)->where("product_id", $produto->id)->where("type", "forecast")->update([
                    'qtd' => -( ($this->venda->produtos->find($produto->id)->pivot->qtd_sale - $this->venda->produtos->find($produto->id)->pivot->qtd_delivered) * (($insumo->pivot->percent)/100))
                ]);
            }
        }
    }

    public function confirmDeleteEntrega($delivery_id)
    {
        $this->entrega_escolhida = Delivery::findOrFail($delivery_id);
        $this->dispatchBrowserEvent("confirma-exclusao-entrega");
    }

    public function deleteEntrega()
    {
       
        //atualizando  saldo da tabela PRODUTO VENDA
        foreach ($this->venda->produtos as $key => $produto) {
            if ($produto->id == $this->entrega_escolhida->entrega_produto_id && $produto->pivot->armazem_id == $this->entrega_escolhida->entrega_armazem_id) {
                $this->venda->produtos()->where("produto_id", $this->entrega_escolhida->entrega_produto_id)->where("armazem_id", $this->entrega_escolhida->entrega_armazem_id)->update([
                    /*
                    "qtd_delivered" => Delivery::where("venda_id", $this->venda->id)->where("entrega_produto_id", $this->entrega_produto_id)->where("entrega_armazem_id", $this->entrega_armazem_id)->sum("entrega_qtd_delivered")
                    */
                    "qtd_delivered" => $produto->pivot->qtd_delivered - $this->entrega_escolhida->entrega_qtd_delivered
                ]);
            }
        }

        $produto = Produto::findOrFail($this->entrega_escolhida->entrega_produto_id);

        foreach ($this->venda->produtos as $key => $produto) {
            foreach ($this->venda->details as $key => $detalhe) {
                $this->venda->details()->where("product_id", $produto->id)->where("armazem_id", $this->entrega_escolhida->entrega_armazem_id)->where("type", "real")->delete();
            }
        }

        $this->venda->entregas()->detach($this->entrega_escolhida->id);

        //$this->actual_delivery->delete();
       
        $this->emitSelf("refresh-me");
        $this->dispatchBrowserEvent("sucesso-deleta-entrega");
        $this->start();
    }

    public function cancel()
    {
        $this->start();
    }

    public function pergunta()
    {
        $this->dispatchBrowserEvent("confirma-encerra-venda");
       
        
        $this->start();
    }

    public function encerraVenda()
    {
        $this->venda->sale_status = "close";
        $this->venda->update();
        $this->start();
        $this->dispatchBrowserEvent("venda-encerrada");
    }

    public function render()
    {
        return view('livewire.movimento.venda-edit');
    }
}
