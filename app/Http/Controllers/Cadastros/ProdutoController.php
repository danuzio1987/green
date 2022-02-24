<?php

namespace App\Http\Controllers\Cadastros;

use App\Http\Controllers\Controller;
use App\Models\Cadastros\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
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
        ["link" => "/", "name" => "Home"],["link" => "/cadastros", "name" => "Cadastros"],["name" => "Produtos"]
        ];
        return view('app.cadastros.produtos.index',[
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
            ["link" => "/", "name" => "Home"], ["link" => "/cadastros", "name" => "Cadastros"], ["link" => "/cadastros/produtos", "name" => "Produtos"], ["name" => "Editar Produto"]
        ];

        $produto = Produto::with("insumos")->findOrFail($id);

        return view('app.cadastros.produtos.edit',[
            'pageConfigs'=>$pageConfigs,
            'breadcrumbs'=>$breadcrumbs,
            'produto' => $produto
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
