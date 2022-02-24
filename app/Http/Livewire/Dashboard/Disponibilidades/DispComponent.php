<?php

namespace App\Http\Livewire\Dashboard\Disponibilidades;

use App\Models\Cadastros\Armazem;
use App\Models\Cadastros\Cliente;
use App\Models\Cadastros\Fornecedor;
use App\Models\Cadastros\Insumo;
use App\Models\Cadastros\Produto;
use App\Models\Cadastros\Usina;
use App\Models\Detalhes\Detalhamento;
use Illuminate\Support\Facades\Date;
use Livewire\Component;

class DispComponent extends Component
{
    //verificando cadastros básicos
    public $usinas_count;
    public $armazens_count;
    public $fornecedores_count;
    public $clientes_count;
    public $insumos_count;
    public $produtos_count;

    public $verifica;

    //variáveis auxiliares
    public $produtos;
    public $armazens;
    public $lancamentos;

    public function mount()
    {
        $this->verificaCadastros();
        if ($this->verifica == true) {
            $this->start();
        }
    }

    public function start()
    {
        $this->produtos = Produto::all();
        $this->armazens = Armazem::all();
        $this->lancamentos = Detalhamento::all();
        $this->tableLabel();
    }

    public function tableLabel()
    {
        /** DEFININDO A LABEL DA TABELA */
        $dataBase1 = Date::parse(date("Y-m-d", strtotime(now())));
        $dataBase2 = Date::parse(date("Y-m-d", strtotime(now())));
        //definindo datas de início e fim do gráfico
        $this->inicio = $dataBase1->startOfMonth();
        $this->final = $dataBase2->endOfMonth();
        $this->start = Date::parse($this->inicio);
        $this->finish = Date::parse($this->final);

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
        return view('livewire.dashboard.disponibilidades.disp-component');
    }
}
