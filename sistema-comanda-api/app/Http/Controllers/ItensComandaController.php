<?php

namespace App\Http\Controllers;

use App\ItensComanda;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ItensComandaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $itens_comanda = ItensComanda::all();

            if(count($itens_comanda) <=0 ) {
                return response()->json(['mensagem' => 'Nada encontrado'], 404);
            }
            return response()->json($itens_comanda, 200);

        }catch(Exception $e){
            return response()->json(['mensagem' => $e]);
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
            $itens_comanda = new ItensComanda();
            $itens_comanda->fill($request->all());

            $itens_comanda->save();

            return response()->json($itens_comanda, 201);
        }
        catch (Exception $e)
        {
            Log::error($e);
            return response()->json(['mensagem' => 'Não foi possível cadastrar os itens da comanda'], 500);
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
            if(!$itens_comanda = ItensComanda::find($id)){
                return response()->json(['mensagem' => 'Não foi possível encontrar o item'], 404);
            }

            return response()->json($itens_comanda, 201);
        }
        catch (Exception $e)
        {
            Log::error($e);
            return response()->json(['mensagem' => 'Não foi possível encontrar o item da comanda'], 500);
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
            if(!$itens_comanda = ItensComanda::find($id)){
                return response()->json(['mensagem' => 'Não foi possível encontrar o item'], 404);
            }

            $itens_comanda['status'] = 'finalizado';

            $itens_comanda->update();

            return response()->json($itens_comanda, 201);
        }
        catch (Exception $e)
        {
            Log::error($e);
            return response()->json(['mensagem' =>'Não foi possível atualizar o item'], 500);
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
            if(!$itens_comanda = ItensComanda::find($id)){
                return response()->json(['mensagem' => 'Não foi possível encontrar o item'], 404);
            }

            $itens_comanda->delete();

            return response()->json($itens_comanda, 201);
        }
        catch (Exception $e)
        {
            Log::error($e);
            return response()->json(['mensagem' => 'Não foi possível deletar o item da comanda'], 500);
        }
    }
}
