<?php

namespace App\Http\Livewire\Movimento;

use App\Models\Cadastros\Armazem;
use App\Models\Cadastros\Cliente;
use App\Models\Cadastros\Produto;
use App\Models\Vendas\Venda;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Livewire\Component;
use Livewire\WithPagination;

class VendaComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    protected $listeners = ["deleteVenda"];

    //filter bar
    public $paginate;
    public $search_produtos;
    public $search_delivery;
    public $allVendas;


    //variáveis da tabela de VENDA
    public $sale_date;
    public $mode;   //venda normal, antecipação ou mudança de propriedade
    public $cliente_id;
    public $retirada;
    public $notes;
    public $sale_status;

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

    //variáveis auxiliares
    public $form_mode;
    public $clientes;
    public $produtos;
    public $armazens;
    public $actual_sale;
    public $sale_mode;  //recorrente ou unica
    public $inicio_recorrencia;
    public $termino_recorrencia;


    //variáveis de inserir itens
    public $i;
    public $inputs;

    public function mount()
    {
        $this->start();
    }

    public function start()
    {
        //filter bar
        $this->paginate = 5;
        $this->search_produtos = "";
        $this->search_delivery = "";
        $this->allVendas = Venda::all();

        //variáveis da tabela VENDAS
        $this->sale_date = date("Y-m-d", strtotime(now()));
        $this->mode = "normal";
        $this->cliente_id = '';
        //$this->produto_id = '';
        //$this->delivery_date = '';
        $this->retirada = '';
        $this->notes = '';
        $this->sale_status = "open";

        //variáveis da tablea PRODUTO_VENDAS
        $this->product_id = '';
        $this->qtd_sale = '';
        //$this->armazem_id = '';
        //$this->detail_type = 'normal';
        $this->qtd_delivered = '';
        $this->date_retirada = '';

        //variáveis da tabela DETALHAMENTO
        $this->user_id = Auth::user()->id;
        $this->insumo_id = "";
        $this->armazem_id = "";
        $this->product_id = "";
        $this->date_report = "";
        $this->document = "";
        $this->type = "real";
        $this->category = "Venda";
        $this->moviment_type = "saida";
        //$this->qtd = "";

        //variáveis auxiliares
        $this->form_mode = "create";
        $this->clientes = Cliente::all();
        $this->produtos = Produto::all();
        $this->armazens = Armazem::all();

        $this->actual_sale = null;
        $this->sale_mode = "unica";
        $this->inicio_recorrencia = "";
        $this->termino_recorrencia = "";

        $this->inputs = [];
        $this->i = 1;

        $this->resetInputFields();
        
    }

    //ITENS DE VENDA
    //limpando os campos
    public function resetInputFields()
    {
        $this->produto_id = "";
        $this->qtd = "";
    }
    //adicionando item
    public function add($i)
    {
        $i = $i + 1;
        $this->i = $i;
        array_push($this->inputs, $i);
    }
    //removendo item
    public function remove($i)
    {
        unset($this->inputs[$i]);
    }
    /**************** */

    public function saleMode()
    {
        $this->sale_mode = "recorrente";
        $this->type = "forecast";
    }


    public function createVenda()
    {
        
        $customMessages = [
            'type.required' => '✋ Falta aqui!',
            'sale_date.required'  => '✋ Campo obrigatório!',
            'armazem_id.required'  => '✋ Campo obrigatório!',
            'date_report.required'  => '✋ Campo obrigatório!',
            'cliente_id.required'  => '✋ Campo obrigatório!',
            'produto_id.0.required'  => '✋ Campo obrigatório!',
            'qtd.0.required'  => '✋ Campo obrigatório!',
            'produto_id.*.required'  => '✋ Campo obrigatório!',
            'qtd.*.required'  => '✋ Campo obrigatório!'
        ];

        $this->validate([
            'type' => 'required',
            'sale_date' => 'required|date',
            'armazem_id' => "required",
            'date_report' => 'required|date',
            'cliente_id' => 'required',
            'produto_id.0' => "required",
            'qtd.0' => "required|numeric",
            'produto_id.*' => "required",
            'qtd.*' => "required|numeric",
        ], $customMessages);    
        
        //criando a venda
        $venda = new Venda();
        $venda->sale_date = date("Y-m-d", strtotime($this->sale_date));
        $venda->mode = $this->mode;
        $venda->cliente_id = $this->cliente_id;
        //$venda->armazem_sale = $this->armazem_id;
        $venda->retirada = date("Y-m-d", strtotime($this->date_report));
        $venda->notes = $this->notes;
        $venda->sale_status = $this->sale_status;
        $venda->save();

        if ($this->mode === "antecipacao") {
            $this->detail_type = "antecipacao";
            $this->type = "forecast";
        } else {
            $this->detail_type = "normal";
        }
        
        //inserindo os PRODUTOS da VENDA
        foreach ($this->produto_id as $key => $value) {
            $venda->produtos()->attach($this->produto_id[$key], [
                "uniq_code" => md5(uniqid(rand(), true)),
                "qtd_sale" => $this->qtd[$key],
                "armazem_id" => $this->armazem_id[$key],
                "detail_type" => $this->detail_type,
                "qtd_delivered" => $this->detail_type === "antecipacao" ? 0 : $this->qtd[$key],
                "date_retirada" => date("Y-m-d", strtotime($this->date_report))
            ]);
        }

        //inserindo as informações no DETALHAMENTO
        foreach ($venda->produtos as $key => $produto) {
            foreach ($produto->insumos as $key => $value) {
                $venda->details()->create([
                    'user_id' => $this->user_id,
                    'insumo_id' => $value->pivot->insumo_id,
                    'armazem_id' => $produto->pivot->armazem_id,
                    'product_id' => $produto->id,
                    "uniq_code" => $produto->pivot->uniq_code,
                    'date_report' => date("Y-m-d", strtotime($this->date_report)),
                    'document' => $this->document,
                    'type' => $this->type,
                    'category' => $this->category,
                    'moviment_type' => $this->moviment_type,
                    'qtd' => -($produto->pivot->qtd_sale * (($value->pivot->percent)/100))
                ]);
            }
        }

        $this->dispatchBrowserEvent("sucesso-salva-venda");
        $this->start(); 
  
    }

    public function createVendaRecorrente()
    {
        $customMessages = [
            'type.required'  => '✋ Campo obrigatório!',
            'inicio_recorrencia.required'  => '✋ Campo obrigatório!',
            'termino_recorrencia.required'  => '✋ Campo obrigatório!',
            'cliente_id.required'  => '✋ Campo obrigatório!',
            'armazem_id.required'  => '✋ Campo obrigatório!',
            'produto_id.0.required'  => '✋ Campo obrigatório!',
            'qtd.0.required'  => '✋ Campo obrigatório!',
            'produto_id.*.required'  => '✋ Campo obrigatório!',
            'qtd.*.required'  => '✋ Campo obrigatório!'
        ];

        $this->validate([
            'type' => "required",
            'inicio_recorrencia' => 'required|date',
            'termino_recorrencia' => 'required|date',
            'cliente_id' => 'required',
            'armazem_id' => "required",
            'produto_id.0' => "required",
            'qtd.0' => "required|numeric",
            'produto_id.*' => "required",
            'qtd.*' => "required|numeric",
        ], $customMessages);
        
        $periodo = [];
        $start_date = Date::parse(date('Y-m-d', strtotime($this->inicio_recorrencia)));
        $finish_date = Date::parse(date('Y-m-d', strtotime($this->termino_recorrencia)));
        $date = $start_date;

        while ($date >= $start_date && $date <= $finish_date) {
            $periodo[] = $date->format('Y-m-d');
            $date->addDay();
        }

        foreach ($periodo as $index => $data) {

            if (date("N", strtotime($data)) !== "6" && date("N", strtotime($data)) !== "7") {
                //criando a venda
                $venda = new Venda();
                $venda->sale_date = date("Y-m-d", strtotime($data));
                $venda->cliente_id = $this->cliente_id;
                //$venda->produto_id = $this->produto_id;
                $venda->armazem_sale = $this->armazem_id;
                $venda->retirada = date("Y-m-d", strtotime($data));
                //$venda->qtd_sale = $this->qtd;
                $venda->notes = $this->notes;
                $venda->save();

                //atualizando a tabela PRODUTO_VENDA
                foreach ($this->produto_id as $key => $value) {
                    $venda->produtos()->attach($this->produto_id[$key], [
                        "qtd_sale" => $this->qtd[$key]
                    ]);
                }

                //atualizando a tabela DETALHAMENTO
                foreach ($venda->produtos as $key => $produto)
                {
                    foreach ($produto->insumos as $key => $value) {
                        $venda->details()->create([
                            'user_id' => $this->user_id,
                            'insumo_id' => $value->pivot->insumo_id,
                            'armazem_id' => $this->armazem_id,
                            'product_id' => $produto->id,
                            'date_report' => date("Y-m-d", strtotime($data)),
                            'document' => $this->document,
                            'type' => $this->type,
                            'category' => $this->category,
                            'moviment_type' => $this->moviment_type,
                            'qtd' => -($produto->pivot->qtd_sale * (($value->pivot->percent)/100))
                        ]);
                    }
                }

                /*
                $produto = Produto::findOrFail($this->produto_id);

                $insumos = $produto->insumos;

                foreach ($insumos as $key => $value) {
        
                        $venda->details()->create([
                            'user_id' => $this->user_id,
                            'insumo_id' => $value->pivot->insumo_id,
                            'armazem_id' => $this->armazem_id,
                            'product_id' => $produto->id,
                            'date_report' => date("Y-m-d", strtotime($data)),
                            'document' => $this->document,
                            'type' => $this->type,
                            'category' => $this->category,
                            'moviment_type' => $this->moviment_type,
                            'qtd' => -($this->qtd * (($value->pivot->percent)/100))
                        ]);
                
                }
                */
            }
  
        }

        $this->dispatchBrowserEvent("sucesso-salva-venda");

        $this->start(); 
  
    }  

    public function showEditFormVenda($venda_id)
    {
        $this->actual_sale = Venda::findOrFail($venda_id);
        $this->form_mode = "edit";
        $this->type = $this->actual_sale->details()->first()->type;
        $this->sale_date = $this->actual_sale->sale_date;
        $this->cliente_id = $this->actual_sale->cliente_id;
        $this->document = $this->actual_sale->details()->first()->document;
        $this->armazem_id = $this->actual_sale->details()->first()->armazem_id;
        $this->date_report = $this->actual_sale->details()->first()->date_report;
        $this->produto_id = $this->actual_sale->produto_id;
        $this->notes = $this->actual_sale->notes;
        $this->qtd = abs($this->actual_sale->qtd_sale);

    }

    public function editVenda()
    {
        $customMessages = [
            'type.required'  => '✋ Campo obrigatório!',
            'sale_date.required'  => '✋ Campo obrigatório!',
            'date_report.required'  => '✋ Campo obrigatório!',
            'armazem_id.required'  => '✋ Campo obrigatório!',
            'produto_id.required'  => '✋ Campo obrigatório!',
            'qtd.required'  => '✋ Campo obrigatório!'
        ];

        $this->validate([
            'type' => 'required',
            'sale_date' => 'required|date',
            'date_report' => 'required|date',
            'armazem_id' => "required",
            'produto_id' => "required",
            'qtd' => "required|numeric",
        ], $customMessages);

        $this->actual_sale->update([
            "sale_date" => $this->sale_date,
            "cliente_id" => $this->cliente_id,
            "produto_id" => $this->produto_id,
            "armazem_sale" => $this->armazem_id,
            "retirada" => $this->date_report,
            "qtd_sale" => $this->qtd,
            "notes" => $this->notes
        ]);

        $produto = Produto::findOrFail($this->actual_sale->produto_id);

        $insumos = $produto->insumos;
 
        foreach ( $insumos as $key => $insumo) {
            $this->actual_sale->details()->where("insumo_id", $insumo->id)->update([
                'user_id' => Auth::user()->id,
                'insumo_id' => $insumo->id,
                'armazem_id' => $this->armazem_id,
                'date_report' => date("Y-m-d", strtotime($this->date_report)),
                'document' => $this->document,
                'type' => $this->type,
                'category' => "Venda",
                'moviment_type' => "saida",
                'qtd' => -($this->qtd * (($insumo->pivot->percent)/100))
            ]);
            /*
            $this->actual_sale->details()->update(
                ["insumo_id" => $insumo->id, "armazem_id" => $this->armazem_id],
                [
                    'user_id' => Auth::user()->id,
                    'insumo_id' => $insumo->id,
                    'armazem_id' => $this->armazem_id,
                    'date_report' => date("Y-m-d", strtotime($this->date_report)),
                    'document' => $this->document,
                    'type' => $this->type,
                    'category' => "Venda",
                    'moviment_type' => "saida",
                    'qtd' => -($this->qtd * (($insumo->pivot->percent)/100))
                ]
            );
            */
        }

        $this->dispatchBrowserEvent("sucesso-edita-venda");

        $this->start(); 


    }

    public function deleteConfirmationVenda($id)
    {
        $this->actual_sale = Venda::findOrFail($id);
        $this->dispatchBrowserEvent("confirma-exclusao-venda");
    }

    public function deleteVenda()
    {
        foreach ($this->actual_sale->details as $key => $detalhe) {
            $detalhe->delete();
        }
        foreach ($this->actual_sale->entregas as $key => $entrega) {
            $entrega->delete();
        }
        $this->actual_sale->delete();
        
        $this->dispatchBrowserEvent("sucesso-deleta-venda");
        $this->start();
    }

    public function cancel()
    {
        $this->start();
    }

    public function render()
    {
        return view('livewire.movimento.venda-component', [
            "vendas" => Venda::with("produtos")
                            ->when($this->search_produtos, function($query){
                                $query->where('produto_id', $this->search_produtos);
                            })
                            ->when($this->search_delivery, function($query){
                                $query->where('sale_date', $this->search_delivery);
                            })
                            ->paginate($this->paginate),
                        ]);
    }
}
