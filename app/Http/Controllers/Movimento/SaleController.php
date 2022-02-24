<?php

namespace App\Http\Controllers\Movimento;

use App\Http\Controllers\Controller;
use App\Models\Vendas\Venda;
use Illuminate\Http\Request;

class SaleController extends Controller
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
        ["link" => "/", "name" => "Home"],["link" => "#", "name" => "Movimentos"],["name" => "Vendas"]
        ];
        return view('app.movimentos.vendas.index',[
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
        //
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
        ["link" => "/", "name" => "Home"],["link" => "#", "name" => "Movimentos"],["link" => "/movimentos/vendas", "name" => "Vendas"],["name" => "Vendas"]
        ];

        $venda = Venda::findOrFail($id);

        return view('app.movimentos.vendas.edit',[
            'pageConfigs'=>$pageConfigs,
            'breadcrumbs'=>$breadcrumbs,
            'venda' => $venda
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
