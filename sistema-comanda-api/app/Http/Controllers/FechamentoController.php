<?php

namespace App\Http\Controllers;

use App\Comanda;
use App\Fechamento;
use App\Mesa;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FechamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $fechamento = Fechamento::with('tipo_pagamentos')->with('comandas')->get();

            if(count($fechamento) <=0 ) {
                return response()->json(['mensagem' => 'Nada encontrado'], 404);
            }
            return response()->json($fechamento, 200);

        }catch(Exception $e){
            return response()->json(['mensagem' => $e] , 500);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try
        {
            $fechamento = new Fechamento();

            $fechamento->fill($request->all());

            if(!$comanda = Comanda::find($request->comandas_id)){
                return response()->json(['mensagem' => 'Não foi possível encontrar a comanda'], 404);
            }

            if(!$mesa = Mesa::find($comanda->mesas_id)){
                return response()->json(['mensagem' => 'Não foi possível encontrar a mesa'], 404);
            }

            $mesa->status = 1;
            $comanda->status = 2;

            $fechamento->save();

            $mesa->update();
            $comanda->update();

            return response()->json([
                'data' => $fechamento,
                'mensagem' => 'Agora é só esperar que um de nossos atendentes vai até você.'
            ], 201);
        }
        catch (Exception $e)
        {
            Log::error($e);
            return response()->json(['mensagem' => 'Não foi possível cadastrar o fechamento'], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try
        {
            if(!$fechamento = Fechamento::find($id)){
                return response()->json(['mensagem' => 'Não foi possível encontrar o fechamento'], 404);
            }

            return response()->json($fechamento, 201);
        }
        catch (Exception $e)
        {
            Log::error($e);
            return response()->json(['mensagem' => 'Não foi possível encontrar a fechamento'], 500);
        }
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
        try
        {
            if(!$fechamento = Fechamento::find($id)){
                return response()->json(['mensagem' => 'Não foi possível encontrar o fechamento'], 404);
            }

            $fechamento->fill($request->all());

            $fechamento->update();

            return response()->json($fechamento, 201);
        }
        catch (Exception $e)
        {
            Log::error($e);
            return response()->json(['mensagem' =>'Não foi possível atualizar o fechamento'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try
        {
            if(!$fechamento = Fechamento::find($id)){
                return response()->json(['mensagem' => 'Não foi possível encontrar o fechamento'], 404);
            }

            $fechamento->delete();

            return response()->json($fechamento, 201);
        }
        catch (Exception $e)
        {
            Log::error($e);
            return response()->json(['mensagem' => 'Não foi possível deletar a fechamento'], 500);
        }
    }
}
