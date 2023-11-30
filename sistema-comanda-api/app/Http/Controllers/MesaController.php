<?php

namespace App\Http\Controllers;

use App\Mesa;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MesaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $mesa = Mesa::all();

            if(count($mesa) <=0 ) {
                return response()->json(['mensagem' => 'Nada encontrado'], 404);
            }
            return response()->json($mesa, 200);

        }catch(Exception $e){
            return response()->json(['mensagem' => $e], 500);
        }
    }

    public function disponiveis()
    {
        try{
            $mesa = Mesa::with('comandas')->where('status', 'livre')->get();

            if(count($mesa) <=0 ) {
                return response()->json(['mensagem' => 'Nada encontrado'], 404);
            }
            return response()->json($mesa, 200);

        }catch(Exception $e){
            return response()->json(['mensagem' => $e], 500);
        }
    }

    public function indisponiveis()
    {
        try{
            $mesa = Mesa::with(['comandas' => function ($query) {
                $query->where('status', 'aberta');
            }])
                ->where('status', 'ocupada')
                ->get();

            if(count($mesa) <=0 ) {
                return response()->json(['mensagem' => 'Nada encontrado'], 404);
            }
            return response()->json($mesa, 200);

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
            $mesa = new Mesa();
            $mesa->fill($request->all());

            $mesa->save();

            return response()->json(['mensagem' => 'Mesa criada com sucesso', 'mesas' => $mesa], 201);
        }
        catch (Exception $e)
        {
            Log::error($e);
            return response()->json(['mensagem' => 'Não foi possível cadastrar a mesa'], 500);
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
            if(!$mesa = Mesa::find($id)){
                return response()->json(['mensagem' => 'Não foi possível encontrar a mesa'], 404);
            }

            return response()->json($mesa, 201);
        }
        catch (Exception $e)
        {
            Log::error($e);
            return response()->json(['mensagem' =>'Não foi possível encontrar a mesa'], 500);
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
            if(!$mesa = Mesa::find($id)){
                return response()->json(['mensagem' => 'Não foi possível encontrar a mesa'], 404);
            }

            $mesa->fill($request->all());

            $mesa->update();

            return response()->json($mesa, 201);
        }
        catch (Exception $e)
        {
            Log::error($e);
            return response()->json(['mensagem' =>'Não foi possível atualizar a mesa'], 500);
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
            if(!$mesa = Mesa::find($id)){
                return response()->json(['mensagem' => 'Não foi possível encontrar a mesa'], 404);
            }

            $mesa->delete();

            return response()->json($mesa, 201);
        }
        catch (Exception $e)
        {
            Log::error($e);
            return response()->json(['mensagem' =>'Não foi possível deletar a mesa'], 500);
        }
    }
}
