<?php

namespace App\Http\Controllers;

use App\TipoPagamento;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TipoPagamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $tipo_pagamento = TipoPagamento::all();

            if(count($tipo_pagamento) <=0 ) {
                return response()->json(['mensagem' => 'Nada encontrado'], 404);
            }
            return response()->json($tipo_pagamento, 200);

        }catch(Exception $e){
            return response()->json(['mensagem' => $e], 500);
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
            $tipo_pagamento = new TipoPagamento();

            $tipo_pagamento->fill($request->all());

            $tipo_pagamento->save();

            return response()->json($tipo_pagamento, 201);
        }
        catch (Exception $e)
        {
            Log::error($e);
            return response()->json(['mensagem' => 'Não foi possível cadastrar o tipo de pagamento'], 500);
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
            if(!$tipo_pagamento = TipoPagamento::find($id)){
                return response()->json(['mensagem' => 'Não foi possível encontrar o tipo de pagamento'], 404);
            }

            return response()->json($tipo_pagamento, 201);
        }
        catch (Exception $e)
        {
            Log::error($e);
            return response()->json(['mensagem' => 'Não foi possível encontrar o tipo de pagamento'], 500);
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
            if(!$tipo_pagamento = TipoPagamento::find($id)){
                return response()->json(['mensagem' => 'Não foi possível encontrar o tipo de pagamento'], 404);
            }

            $tipo_pagamento->fill($request->all());

            $tipo_pagamento->update();

            return response()->json($tipo_pagamento, 201);
        }
        catch (Exception $e)
        {
            Log::error($e);
            return response()->json(['mensagem' =>'Não foi possível atualizar o tipo de pagamento'], 500);
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
            if(!$tipo_pagamento = TipoPagamento::find($id)){
                return response()->json(['mensagem' => 'Não foi possível encontrar o tipo de pagamento'], 404);
            }

            $tipo_pagamento->delete();

            return response()->json($tipo_pagamento, 201);
        }
        catch (Exception $e)
        {
            Log::error($e);
            return response()->json(['mensagem' => 'Não foi possível deletar o tipo de pagamento'], 500);
        }
    }
}
