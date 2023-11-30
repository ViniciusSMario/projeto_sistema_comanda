<?php

namespace App\Http\Controllers;

use App\Categoria;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $categoria = Categoria::all();

            if(count($categoria) <=0 ) {
                return response()->json(['mensagem' => 'Nada encontrado'], 404);
            }
            return response()->json($categoria, 200);

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
            $categoria = new Categoria();

            $categoria->fill($request->all());

            $categoria->save();

            return response()->json($categoria, 201);
        }
        catch (Exception $e)
        {
            Log::error($e);
            return response()->json(['mensagem' =>'Não foi possível cadastrar a categoria'], 500);
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
            if(!$categoria = Categoria::find($id)){
                return response()->json(['mensagem' => 'Não foi possível encontrar a categoria'], 404);
            }

            return response()->json($categoria, 201);
        }
        catch (Exception $e)
        {
            Log::error($e);
            return response()->json(['mensagem' =>'Não foi possível encontrar a categoria'], 500);
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
            if(!$categoria = Categoria::find($id)){
                return response()->json(['mensagem' => 'Não foi possível encontrar a categoria'], 404);
            }

            $categoria->fill($request->all());

            $categoria->update();

            return response()->json($categoria, 201);
        }
        catch (Exception $e)
        {
            Log::error($e);
            return response()->json(['mensagem' =>'Não foi possível atualizar a categoria'], 500);
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
            if(!$categoria = Categoria::find($id)){
                return response()->json(['mensagem' => 'Não foi possível encontrar a categoria'], 404);
            }

            $categoria->delete();

            return response()->json($categoria, 201);
        }
        catch (Exception $e)
        {
            Log::error($e);
            return response()->json(['mensagem' =>'Não foi possível deletar a categoria'], 500);
        }
    }
}
