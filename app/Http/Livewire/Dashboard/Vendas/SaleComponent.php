<?php

namespace App\Http\Livewire\Dashboard\Vendas;

use App\Models\Cadastros\Armazem;
use App\Models\Cadastros\Cliente;
use App\Models\Cadastros\Fornecedor;
use App\Models\Cadastros\Insumo;
use App\Models\Cadastros\Produto;
use App\Models\Cadastros\Usina;
use App\Models\Detalhes\Detalhamento;
use App\Models\Vendas\Venda;
use Illuminate\Support\Facades\Date;
use Livewire\Component;

class SaleComponent extends Component
{

    //verificando cadastros básicos
    public $usinas_count;
    public $armazens_count;
    public $fornecedores_count;
    public $clientes_count;
    public $insumos_count;
    public $produtos_count;

    public $verifica;



    public $armazens;
    public $produtos;
    public $vendas;
    public $report_date;

    

    public $labels;
    public $datas;
    public $data_inferior;
    public $start;
    public $finish;
    public $detalhes;

    public function mount()
    {
        $this->verificaCadastros();
        if ($this->verifica == true) {
            $this->start();
            $this->updateDashboardVendas();
        }
        
    }

    public function start()
    {
        $this->armazens = Armazem::with("insumos")->orderBy("name", "asc")->get();
        $this->produtos = Produto::with("insumos")->get();
        $this->vendas = Venda::with("produto")->get();
    
        $this->report_date = date("Y-m-d", strtotime(now()));
        $this->data_inferior = date("Y-m-d", strtotime("2005-01-01"));
        $this->detalhes = Detalhamento::where("category", "Venda")->get();
        
    }

    public function updateDashboardVendas()
    {
        /** DEFININDO A LABEL DA TABELA */
        $dataBase1 = Date::parse(date("Y-m-d", strtotime($this->report_date)));
        $dataBase2 = Date::parse(date("Y-m-d", strtotime($this->report_date)));
        //definindo datas de início e fim do gráfico
        $this->inicio = $dataBase1->startOfMonth();
        $this->final = $dataBase2->endOfMonth();
        $this->start = Date::parse($this->inicio);
        $this->finish = Date::parse($this->final);

       //lançamentos do período
        //$this->lancamentos = Detalhamento::with("armazem")->with("insumos")->where("armazem_id", $this->armazem_id)->whereBetween("date_report", [$this->start, $this->finish])->get();

        $start_month = $this->start->day;
        $end_month = $this->finish->day;

        //dados para o loop
        $end_month = $this->finish->diffInDays($this->start);
        $start_month = 0;

        //criação das labels da tabela (dias do mês corrente)
        $this->labels = [];
        $this->datas = [];

        $s = clone $this->start;

        for ($i = $end_month; $i >= $start_month ; $i--) { 
            $this->labels[$end_month - $i] = $s->format('d/m');
            $this->datas[$end_month - $i] = $s->format('Y-m-d');
            $s->addDay();
        }
         /** FIM LABEL DA TABELA */


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
        return view('livewire.dashboard.vendas.sale-component');
    }
}
