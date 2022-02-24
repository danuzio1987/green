<?php

namespace App\Http\Controllers;

use App\Models\Cadastros\Armazem;
use App\Models\Cadastros\Cliente;
use App\Models\Cadastros\Fornecedor;
use App\Models\Cadastros\Insumo;
use App\Models\Cadastros\Produto;
use App\Models\Cadastros\Usina;
use App\Models\Pedidos\Pedido;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    //página inicial
    public function home()
    {
        $pageConfigs = ['pageHeader' => true];

        $breadcrumbs = [
        ["link" => "/", "name" => "Home"], ["name" => "Minha Página Inicial"]
        ];

        return view('home',[
            'pageConfigs'=>$pageConfigs,
            'breadcrumbs'=>$breadcrumbs
        ]);
    }

    //dashboard geral
    public function geral()
    {
        $pageConfigs = ['pageHeader' => true];

        $breadcrumbs = [
            ["link" => "/", "name" => "Home"], ["link" => "#", "name" => "Dashboards"],["name" => "Geral"]
        ];
        return view('geral',[
            'pageConfigs'=>$pageConfigs,
            'breadcrumbs'=>$breadcrumbs
        ]);
    }

    //dashboard dos armazens
    public function armazens()
    {
        $pageConfigs = ['pageHeader' => true];

        $breadcrumbs = [
        ["link" => "/", "name" => "Home"], ["link" => "#", "name" => "Dashboards"],["name" => "Armazéns"]
        ];

        return view('app.dashboards.armazens.index',[
            'pageConfigs'=>$pageConfigs,
            'breadcrumbs'=>$breadcrumbs,
        ]);
    }

    //dashboard dos vendas
    public function vendas()
    {
        $pageConfigs = ['pageHeader' => true];

        $breadcrumbs = [
        ["link" => "/", "name" => "Home"], ["link" => "#", "name" => "Dashboards"],["name" => "Vendas"]
        ];

        return view('app.dashboards.vendas.index',[
            'pageConfigs'=>$pageConfigs,
            'breadcrumbs'=>$breadcrumbs,
        ]);
    }

    //dashboard dos vendas
    public function disponibilidades()
    {
        $pageConfigs = ['pageHeader' => true];

        $breadcrumbs = [
        ["link" => "/", "name" => "Home"], ["link" => "#", "name" => "Dashboards"],["name" => "Disponibilidades"]
        ];

        return view('app.dashboards.disponibilidades.index',[
            'pageConfigs'=>$pageConfigs,
            'breadcrumbs'=>$breadcrumbs,
        ]);
    }

    //dashboard dos transferências
    public function transferencias()
    {
        $pageConfigs = ['pageHeader' => true];

        $breadcrumbs = [
        ["link" => "/", "name" => "Home"], ["link" => "#", "name" => "Dashboards"],["name" => "Transferências"]
        ];

        return view('app.dashboards.transferencias.index',[
            'pageConfigs'=>$pageConfigs,
            'breadcrumbs'=>$breadcrumbs,
        ]);
    }

    //tela de cadastros
    public function cadastros()
    {
        $pageConfigs = ['pageHeader' => true];

        $breadcrumbs = [
        ["link" => "/", "name" => "Home"],["name" => "Cadastros"]
        ];

        return view('app.cadastros.index',[
            'pageConfigs'=>$pageConfigs,
            'breadcrumbs'=>$breadcrumbs,
        ]);
    }

}
