<?php

namespace App\Http\Livewire\Dashboard\Armazem;

use App\Models\Cadastros\Armazem;
use App\Models\Cadastros\Cliente;
use App\Models\Cadastros\Fornecedor;
use App\Models\Cadastros\Insumo;
use App\Models\Cadastros\Produto;
use App\Models\Cadastros\Usina;
use App\Models\Detalhes\Detalhamento;
use App\Models\Pedidos\Pedido;
use App\Models\User;
use Illuminate\Support\Facades\Date;
use Livewire\Component;

class ArmazemDashboard extends Component
{
    //verificando cadastros básicos
    public $usinas_count;
    public $armazens_count;
    public $fornecedores_count;
    public $clientes_count;
    public $insumos_count;
    public $produtos_count;

    public $verifica;


    //variáveia para tabelas de análise
    public $armazem_id;
    public $inicio;
    public $final;
    public $lancamentos;
    public $labels;
    public $dataDan;
    public $amounts;
    public $amounts_mes_anterior;

    public $entradas_navios;
    public $ajustes_estoques;
    public $emprestimos;
    public $vendas;
    public $transferencias;

    //variáveis auxiliares
    public $armazens;
    public $insumos;
    public $actual_armazem;
    public $insumo_id;
    public $report_date;

    //variáveis para  informações
    public $start;
    public $finish;

    public $detalhes;

    public $data_inferior;

    //tabela
    public $pedidos;

    //filtro de navios
    public $data_navio;
    public $lancamentos_navios;
    public $insumo_navio;
    public $armazem_navio;
    public $user_navio;
    public $usina_navio;
    public $pedido_navio;
    


    public function mount()
    {
        $this->verificaCadastros();
        if ($this->verifica == true) {
            $this->start();
            $this->updateDashboard($this->armazem_id, $this->report_date);
        }
        
    }

    public function start()
    {
        
        $this->data_inferior = date('Y-m-d', strtotime('2005-01-01'));

        $this->armazem_id = Armazem::with("insumos")->orderBy("name", "asc")->first()->id;
        $this->report_date = date("Y-m", strtotime(now()));

        $this->armazens = Armazem::with("insumos")->orderBy("name", "asc")->get();
        //$this->insumos = Insumo::all();

        $this->detalhes = Detalhamento::all();
        $this->pedidos = Pedido::with('insumos')->with('details')->get();

        $this->clearNavio();

    }

    public function updateDashboard()
    {
        $this->actual_armazem = Armazem::with("insumos")->findOrFail($this->armazem_id);
        $this->labels = [];
        $this->lancamentos = null;
        
        //gerando dados para os gráficos
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
        $this->dataDan = [];

        $s = clone $this->start;

        for ($i = $end_month; $i >= $start_month ; $i--) { 
            $this->labels[$end_month - $i] = $s->format('Y-m-d');
            $this->dataDan[$end_month - $i] = $s->format('Y-m-d');
            $s->addDay();
        }

       
        foreach ($this->actual_armazem->insumos as $index => $insumo) {
            $this->calculaTotais($insumo->id);
            $this->calculaTotaisAcumulados($insumo->id);
        }

    }

    public function clearNavio()
    {
        $this->data_navio = null;
        $this->lancamentos_navios = null;
        $this->insumo_navio = null;
        $this->armazem_navio = $this->armazem_id;
        $this->user_navio = null;
        $this->usina_navio = null;
        $this->pedido_navio = null;
    }

    public function filtraNavio($index, $insumo_id, $armazem_id)
    {
        $this->data_navio = $this->labels[$index];
        $this->insumo_navio = Insumo::find($insumo_id);
        $this->armazem_navio = Armazem::find($armazem_id);
        $this->usina_navio = Usina::all();
        $this->user_navio = User::all();
        $this->pedido_navio = Pedido::all();

        $this->lancamentos_navios = Detalhamento::where("date_report", date("Y-m-d", strtotime($this->data_navio)))->where("armazem_id", $this->armazem_navio->id)->where("insumo_id", $this->insumo_navio->id)->where("category", "Entrada Navio")->get();
    
        $this->dispatchBrowserEvent("modalNavio");
    }

   

    public function calculaTotais($insumo_id)
    {
        $lancamentos = Detalhamento::with("armazem")->with("insumos")->where("armazem_id", $this->armazem_id)->where("insumo_id", $insumo_id)->where("type", "!=", "canceled")->whereBetween("date_report", [$this->start, $this->finish])->get();
        $this->amounts[$insumo_id] = $this->calculateAmounts($lancamentos, $this->start, $this->finish);
        return $this->amounts;
    }

    public function calculaTotaisAcumulados($insumo_id)
    {
        $inicio_ficticio = Date::parse(date("Y-m-d", strtotime("2005-01-01")));
        $lancamentos = Detalhamento::with("armazem")->with("insumos")->where("armazem_id", $this->armazem_id)->where("insumo_id", $insumo_id)->where("type", "!=", "canceled")->whereBetween("date_report", [$inicio_ficticio, $this->start])->get();
        $this->amounts_mes_anterior[$insumo_id] = $this->calculateAmounts($lancamentos, $inicio_ficticio, $this->start);
        
        return $this->amounts_mes_anterior;
    }

    //cálculo das quantidades por categoria
    public function calculateAmounts($lancamentos, $start, $end)
    {
        $categories = ["Entrada Navio", "Ajuste Estoque", "Empréstimo/Devolução", "Venda", "Transferência"];
        $date_format = "Y-m-d";

        $n=1;
        $start_date = $start->format($date_format);
        $end_date = $end->format($date_format);
        $next_date = $start_date;

        $s = clone $start;

     
        while($next_date <= $end_date)
        {
            $categories['Entrada Navio'][$next_date] = $categories['Ajuste Estoque'][$next_date] = $categories['Empréstimo/Devolução'][$next_date] = $categories['Venda'][$next_date] = $categories['Transferência'][$next_date] = 0;
            $next_date = $s->addDay($n)->format($date_format);
        }

        $this->setAmounts($categories, $lancamentos, $date_format);

        return $categories;

    }

    public function setAmounts(&$categories, $lancamentos, $date_format)
    {
        $today = Date::today()->format('Y-m-d');

        foreach ($lancamentos as $lancamento) {
            
            $date = Date::parse($lancamento->date_report)->format($date_format);

            $amount = $lancamento;

            switch ($lancamento->category) {
                case 'Entrada Navio':
                    $categories['Entrada Navio'][$date] += $amount->qtd;
                    break;
                case 'Ajuste Estoque':
                    $categories['Ajuste Estoque'][$date] += $amount->qtd;
                    break;
                case 'Empréstimo/Devolução':
                    $categories['Empréstimo/Devolução'][$date] += $amount->qtd;
                    break;
                case 'Venda':
                    $categories['Venda'][$date] += $amount->qtd;
                    break;
                case 'Transferência':
                    $categories['Transferência'][$date] += $amount->qtd;
                    break;
                default:
                    $categories['Ajuste Estoque'][$date] += $amount->qtd;
                    break;
            }



        }
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
        return view('livewire.dashboard.armazem.armazem-dashboard');
    }
}
