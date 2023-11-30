<?php

namespace App\Http\Controllers;

use App\Produto;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $produto = Produto::orderBy('nome', 'asc')->get();

            if(count($produto) <=0 ) {
                return response()->json(['mensagem' => 'Nenhum produto encontrado'], 404);
            }
            return response()->json($produto, 200);

        }catch(Exception $e){
            return response()->json(['mensagem' => $e],500);
        }
    }

    public function produtosFiltrados(Request $request)
    {
        try{
            $produto = Produto::orderBy('nome', 'asc')
                ->when($request->has('termo') && !empty($request->input('termo')), function ($query) use ($request) {
                    $query->where('nome', 'like', '%'.$request->input('termo'). '%');
                })
                ->when($request->has('id_categoria') && !empty($request->input('id_categoria')), function ($query) use ($request) {
                    $query->where('categorias_id', $request->input('id_categoria'));
                })
                ->get();

            if(count($produto) <=0 ) {
                return response()->json(['sucesso' => false,'mensagem' => 'Nenhum produto encontrado'], 200);
            }
            return response()->json($produto, 200);

        }catch(Exception $e){
            return response()->json(['mensagem' => $e],500);
        }
    }

    public function store(Request $request)
    {
        try
        {
            $produto = new Produto();
            $produto->fill($request->all());

            $produto->save();

            return response()->json($produto, 201);
        }
        catch (Exception $e)
        {
            Log::error($e);
            return response()->json(['mensagem' =>'Não foi possível cadastrar a produto'], 500);
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
            if(!$produto = Produto::find($id)){
                return response()->json(['mensagem' => 'Não foi possível encontrar o produto!'], 404);
            }

            return response()->json($produto, 201);
        }
        catch (Exception $e)
        {
            Log::error($e);
            return response()->json(['mensagem' =>'Não foi possível encontrar a produto'], 500);
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
            if(!$produto = Produto::find($id)){
                return response()->json(['mensagem' => 'Não foi possível encontrar o produto'], 404);
            }

            $produto->fill($request->all());

            $produto->update();

            return response()->json($produto, 201);
        }
        catch (Exception $e)
        {
            Log::error($e);
            return response()->json(['mensagem' =>'Não foi possível atualizar o produto'], 500);
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
            if(!$produto = Produto::find($id)){
                return response()->json(['mensagem' => 'Não foi possível encontrar o produto!'], 404);
            }

            $produto->delete();

            return response()->json($produto, 201);
        }
        catch (Exception $e)
        {
            Log::error($e);
            return response()->json(['mensagem' =>'Não foi possível deletar a produto'], 500);
        }
    }

    public function show_by_categoria($id) {
        try
        {
            $produtos = Produto::whereCategoriasId($id)->get();
            return response()->json($produtos, 200);

        }
        catch (Exception $e)
        {
            Log::error($e);
            return response()->json(['mensagem' =>'Não foi possível finalizar a pesquisa'], 500);
        }
    }
}
