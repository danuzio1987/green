<?php

namespace App\Http\Livewire\Movimento;

use App\Models\Cadastros\Armazem;
use App\Models\Cadastros\Cliente;
use App\Models\Cadastros\Fornecedor;
use App\Models\Cadastros\Insumo;
use App\Models\Detalhes\Detalhamento;
use App\Models\Transferencias\Transferencia;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class TransferenciaComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['deleteTransferencia'];

    //filter bar
    public $paginate;
    public $search_origem;
    public $search_destino;
    public $search_date;
    public $allTransfer;

    //variáveis de tabela de TRANSFERÊNCIAS
    public $transfer_date;
    public $descarga_date;
    public $delivery_status;
    public $origem_id;
    public $qtd_origem;
    public $destino_id;
    public $qtd_destino;
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
    public $armazens;
    public $insumos;
    public $clientes;
    public $fornecedores;
    public $actual_transfer;


    public function mount()
    {
        $this->start();
    }

    public function start()
    {
        //filter bar
        $this->paginate = 5;
        $this->search_origem;
        $this->search_destino;
        $this->search_date;
        $this->allTransfer = Transferencia::all();

         //variáveis de tabela de TRANSFERÊNCIAS
        $this->transfer_date = date("Y-m-d", strtotime(now()));
        $this->descarga_date = date("Y-m-d", strtotime('+2 days', strtotime(now())));
        $this->delivery_status = "andamento";
        $this->origem_id = "";
        $this->qtd_origem = "";
        $this->destino_id = "";
        $this->qtd_destino = "";
        $this->notes = "";

        //variáveis da tabela DETALHAMENTO
        $this->user_id = Auth::user()->id;
        $this->insumo_id = "";
        $this->armazem_id = "";
        $this->date_report = "";
        $this->document = "";
        $this->type = "real";
        $this->category = "Transferência";
        $this->moviment_type = "";
        $this->qtd = "";

        //variáveis auxiliares
        $this->form_mode = "create";
        $this->insumos = Insumo::all();
        $this->armazens = Armazem::all();
        $this->clientes = Cliente::all();
        $this->fornecedores = Fornecedor::all();
        $this->actual_transfer = null;

    }

    public function createTransferencia()
    {
        $customMessages = [
            'transfer_date.required'  => '✋ Campo obrigatório!',
            'descarga_date.required'  => '✋ Campo obrigatório!',
            'delivery_status.required'  => '✋ Campo obrigatório!',
            'origem_id.required'  => '✋ Campo obrigatório!',
            'qtd_origem.required'  => '✋ Campo obrigatório!',
            'destino_id.required'  => '✋ Campo obrigatório!',
            'qtd_destino.required'  => '✋ Campo obrigatório!',
            'insumo_id.required'  => '✋ Campo obrigatório!',
        ];

        $this->validate([
            'transfer_date' => 'required|date',
            'descarga_date' => 'required|date',
            'delivery_status' => "required",
            'origem_id' => "required",
            'qtd_origem' => 'required',
            'destino_id' => "required",
            'qtd_destino' => "required",
            'insumo_id' => "required",
        ], $customMessages);

        //criando a transferência
        $transferencia = new Transferencia();
        $transferencia->transfer_date = date("Y-m-d", strtotime($this->transfer_date));
        $transferencia->descarga_date = date("Y-m-d", strtotime($this->descarga_date));
        $transferencia->delivery_status = $this->delivery_status;
        $transferencia->origem_id = $this->origem_id;
        $transferencia->qtd_origem = $this->qtd_origem;
        $transferencia->destino_id = $this->destino_id;
        $transferencia->qtd_destino = $this->qtd_destino;
        $transferencia->notes = $this->notes;
        $transferencia->save();

        //operação de saída
        $transferencia->details()->create([
            'user_id' => $this->user_id,
            'insumo_id' => $this->insumo_id,
            'armazem_id' => $this->origem_id,
            'date_report' => date("Y-m-d", strtotime($this->transfer_date)),
            'document' => $this->document,
            'type' => $this->type,
            'category' => $this->category,
            'moviment_type' => "saida",
            'qtd' => -$this->qtd_origem
        ]);

        //operação de entrada
        $transferencia->details()->create([
            'user_id' => $this->user_id,
            'insumo_id' => $this->insumo_id,
            'armazem_id' => $this->destino_id,
            'date_report' => date("Y-m-d", strtotime($this->descarga_date)),
            'document' => $this->document,
            'type' => $this->type,
            'category' => $this->category,
            'moviment_type' => "entrada",
            'qtd' => $this->qtd_destino
        ]);

        //operação de entrada [só é registrada se o status for concluído]
        /*
        if ($this->delivery_status === "concluida") {
            $transferencia->details()->create([
                'user_id' => $this->user_id,
                'insumo_id' => $this->insumo_id,
                'armazem_id' => $this->destino_id,
                'date_report' => date("Y-m-d", strtotime($this->descarga_date)),
                'document' => $this->document,
                'type' => $this->type,
                'category' => $this->category,
                'moviment_type' => "entrada",
                'qtd' => $this->qtd_destino
            ]);
        }
        */
       
        $this->dispatchBrowserEvent('nova-transferencia', [
            'insumo' => Insumo::find($this->insumo_id)->name,
            'armazem_origem' => Armazem::find($transferencia->origem_id)->name,
            'armazem_destino' => Armazem::find($transferencia->destino_id)->name,
            'volume' => $this->qtd_origem
        ]);
        //$this->dispatchBrowserEvent("sucesso-salva-transferencia");
        $this->start(); 

    }

    public function showFormEditTransferencia($id)
    {
        $this->actual_transfer = Transferencia::findOrFail($id);
        $this->form_mode = "edit";
        $this->transfer_date = date("Y-m-d", strtotime($this->actual_transfer->transfer_date));
        $this->descarga_date = date("Y-m-d", strtotime($this->actual_transfer->descarga_date));
        $this->delivery_status = $this->actual_transfer->delivery_status;
        $this->insumo_id = $this->actual_transfer->details()->where("detail_id", $this->actual_transfer->id)->first()->insumo_id;
        $this->origem_id = $this->actual_transfer->origem_id;
        $this->destino_id = $this->actual_transfer->destino_id;
        $this->qtd_origem = abs($this->actual_transfer->qtd_origem);
        $this->qtd_destino =  abs($this->actual_transfer->qtd_destino);
        //$this->qtd = abs($this->actual_transfer->details()->where("detail_id", $this->actual_transfer->id)->first()->qtd);
        $this->notes = $this->actual_transfer->notes;
    }

    public function editTransferencia()
    {

        $customMessages = [
            'transfer_date.required'  => '✋ Campo obrigatório!',
            'descarga_date.required'  => '✋ Campo obrigatório!',
            'delivery_status.required'  => '✋ Campo obrigatório!',
            'origem_id.required'  => '✋ Campo obrigatório!',
            'destino_id.required'  => '✋ Campo obrigatório!',
            'insumo_id.required'  => '✋ Campo obrigatório!',
            'qtd_origem.required'  => '✋ Campo obrigatório!',
            'qtd_destino.required'  => '✋ Campo obrigatório!',
        ];

        $this->validate([
            'transfer_date' => 'required|date',
            'descarga_date' => 'required|date',
            'delivery_status' => "required",
            'origem_id' => "required",
            'destino_id' => "required",
            'insumo_id' => "required",
            'qtd_origem' => 'required|numeric',
            'qtd_destino' => 'required|numeric'
        ], $customMessages);

        //atualizando a transferência
        $this->actual_transfer->update([
            "transfer_date" => date("Y-m-d", strtotime($this->transfer_date)),
            "descarga_date" => date("Y-m-d", strtotime($this->descarga_date)),
            "delivery_status" => $this->delivery_status,
            "origem_id" => $this->origem_id,
            "qtd_origem" => -$this->qtd_origem,
            "qtd_destino" => $this->qtd_destino,
            "destino_id" => $this->destino_id,
            "notes" => $this->notes
        ]);

        //operação de saída
        $this->actual_transfer->details()->where("detail_id", $this->actual_transfer->id)->where("moviment_type", "saida")->update([
            'user_id' => Auth::user()->id,
            'insumo_id' => $this->insumo_id,
            'armazem_id' => $this->origem_id,
            'date_report' => $this->actual_transfer->transfer_date,
            'document' => $this->document,
            'type' => $this->type,
            'category' => $this->category,
            'moviment_type' => "saida",
            'qtd' => -$this->qtd_origem
        ]);
        //operação de entrada
        //1ª hipótese - o usuario marca que a operação está concluída
        if ($this->delivery_status === "concluida")
        {
            $this->actual_transfer->details()->updateOrCreate(
                [
                    'detail_id' => $this->actual_transfer->id,
                    'moviment_type' => 'entrada'
                ],
                [
                    //'detail_type' => 'App\Models\Transferencias\Transferencia',
                    'user_id' => Auth::user()->id,
                    'insumo_id' => $this->insumo_id,
                    'armazem_id' => $this->destino_id,
                    'date_report' => $this->actual_transfer->descarga_date,
                    'document' => $this->document,
                    'type' => $this->type,
                    'category' => $this->category,
                    'moviment_type' => "entrada",
                    'qtd' => $this->qtd_destino 
                ]
            );
            /*
                $this->actual_transfer->details()->where("detail_id", $this->actual_transfer->id)->where("moviment_type", "entrada")->update([
                    'user_id' => Auth::user()->id,
                    'insumo_id' => $this->insumo_id,
                    'armazem_id' => $this->destino_id,
                    'date_report' => $this->actual_transfer->descarga_date,
                    'document' => $this->document,
                    'type' => $this->type,
                    'category' => $this->category,
                    'moviment_type' => "entrada",
                    'qtd' => $this->qtd
                ]);
            */
        }

        //2ª hipótese - o usuário marca como andamento
        //verifica se já havia um registro antes e o apaga
        if ($this->delivery_status === "andamento" && $this->actual_transfer->details()->where("detail_id", $this->actual_transfer->id)->where("moviment_type", "entrada")->count() > 0) 
        {
            $this->actual_transfer->details()->where("detail_id", $this->actual_transfer->id)->where("moviment_type", "entrada")->delete();
        }

        
        $this->dispatchBrowserEvent("sucesso-edita-transferencia");

        $this->start(); 

    }

    public function deleteConfirmationTransferencia($id)
    {
        $this->actual_transfer = Transferencia::findOrFail($id);
        $this->dispatchBrowserEvent("confirma-exclusao-transferencia");
    }

    public function deleteTransferencia()
    {
        foreach ($this->actual_transfer->details as $key => $detalhe) {
            $detalhe->delete();
        }
        $this->actual_transfer->delete();
        
        $this->dispatchBrowserEvent("sucesso-deleta-transferencia");
        $this->start();
    }

    public function cancel()
    {
        $this->start();
    }



    public function render()
    {
        return view('livewire.movimento.transferencia-component', [
            "transferencias" => Transferencia::when($this->search_origem, function($query){
                                                    $query->where('origem_id', $this->search_origem);
                                                })
                                                ->when($this->search_destino, function($query){
                                                    $query->where('destino_id', $this->search_destino);
                                                })
                                                ->when($this->search_date, function($query){
                                                    $query->where('transfer_date', $this->search_date);
                                                })
                                                ->paginate($this->paginate),
                ]);
    }
}
