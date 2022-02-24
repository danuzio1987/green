<?php

namespace App\Http\Controllers\ComprasGov;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;

class GovController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function teste()
    {
        $pageConfigs = ['pageHeader' => true];

        $breadcrumbs = [
        ["link" => "/", "name" => "Home"],["link" => "/cadastros", "name" => "Cadastros"],["name" => "Meus Armazéns"]
        ];


        /*
        $url = "http://compras.dados.gov.br/licitacoes/id/licitacao/15303605000302018.html";
        $client = curl_init($url);
        $headers = ['chave-api-dados: 0165d0ee415ea4d6bed692216a99f474'];
    
    
        curl_setopt($client, CURLOPT_HTTPHEADER, $headers);
    
        curl_setopt($client,CURLOPT_RETURNTRANSFER,true);
    
        $response = curl_exec($client);
    
    
        $orgaos = json_decode($response);
        

        d($orgaos);
        */

        $pedido = Http::get("http://compras.dados.gov.br/licitacoes/id/licitacao/15303605000302018.html");
        dd($pedido->status());




        return view('app.teste-api.index',[
            'pageConfigs'=>$pageConfigs,
            'breadcrumbs'=>$breadcrumbs
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
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
