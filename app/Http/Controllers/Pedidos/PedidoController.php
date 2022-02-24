<?php

namespace App\Http\Controllers\Pedidos;

use App\Http\Controllers\Controller;
use App\Models\Pedidos\Pedido;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageConfigs = ['pageHeader' => true];

        $breadcrumbs = [
        ["link" => "/", "name" => "Home"],["link" => "/pedidos/pedidos", "name" => "Pedidos"],["name" => "Meus Pedidos"]
        ];
        return view('app.pedidos.pedidos.index',[
            'pageConfigs'=>$pageConfigs,
            'breadcrumbs'=>$breadcrumbs
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function lista()
    {
        $pageConfigs = ['pageHeader' => true];

        $breadcrumbs = [
        ["link" => "/", "name" => "Home"],["link" => "/pedidos/pedidos", "name" => "Pedidos"],["name" => "Meus Pedidos"]
        ];
        return view('app.pedidos.pedidos.lista',[
            'pageConfigs'=>$pageConfigs,
            'breadcrumbs'=>$breadcrumbs
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pageConfigs = ['pageHeader' => true];

        $breadcrumbs = [
        ["link" => "/", "name" => "Home"],["link" => "/pedidos/pedidos", "name" => "Pedidos"],["name" => "Detalhes do Pedido"]
        ];
        return view('app.pedidos.pedidos.show',[
            'pageConfigs'=>$pageConfigs,
            'breadcrumbs'=>$breadcrumbs
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pageConfigs = ['pageHeader' => true];

        $breadcrumbs = [
        ["link" => "/", "name" => "Home"],["link" => "/pedidos/pedidos", "name" => "Pedidos"],["name" => "Editar Pedido"]
        ];

        $pedido = Pedido::with("insumos")->with("fornecedor")->with("usina")->findOrFail($id);


        return view('app.pedidos.pedidos.edit',[
            'pageConfigs'=>$pageConfigs,
            'breadcrumbs'=>$breadcrumbs, 
            'pedido' => $pedido
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
