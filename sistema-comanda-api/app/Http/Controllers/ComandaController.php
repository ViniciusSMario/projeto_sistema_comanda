<?php

namespace App\Http\Controllers;

use App\Comanda;
use App\ItensComanda;
use App\Mesa;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;

class ComandaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $comanda = Comanda::all();

            if(count($comanda) <=0 ) {
                return response()->json(['mensagem' => 'Nada encontrado'], 404);
            }
            return response()->json($comanda, 200);

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
            $comanda = new Comanda();
            $comanda->fill($request->all());

            if(!$mesa = Mesa::find($request->mesas_id)){
                return response()->json(['mensagem' => 'Não foi possível encontrar a mesa'], 404);
            }
            $mesa_ocupada = Comanda::where([
                'mesas_id' => $request->mesas_id,
                'status' => 1
            ])->get();

            if(count($mesa_ocupada) > 0){
                return response()->json(['mensagem' => 'Mesa indisponível'], 404);
            }

            $mesa->status = 2;

            $comanda->save();

            $mesa->update();

            return response()->json(['mensagem' => 'Comanda criada com sucesso!', 'comandas' => $comanda], 201);
        }
        catch (Exception $e)
        {
            Log::error($e);
            return response()->json(['mensagem' => 'Não foi possível cadastrar a comanda'], 500);
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
            if(!$comanda = Comanda::find($id)){
                return response()->json(['mensagem' => 'Não foi possível encontrar a comanda'], 404);
            }

            return response()->json($comanda, 201);
        }
        catch (Exception $e)
        {
            Log::error($e);
            return response()->json(['mensagem' => 'Não foi possível encontrar a comanda'], 500);
        }
    }

    public function comanda_with_mesa($id)
    {
        try
        {
            if(!$comanda = Comanda::where('id', $id)->with('mesas')->get()){
                return response()->json(['mensagem' => 'Não foi possível encontrar a comanda'], 404);
            }

            return response()->json(['comanda' => $comanda], 201);
        }
        catch (Exception $e)
        {
            Log::error($e);
            return response()->json(['mensagem' => 'Não foi possível encontrar a comanda'], 500);
        }
    }

    public function comanda_with_itens($id)
    {
        try
        {
            if(!$comanda = Comanda::where('id', $id)
                ->with('itens_comandas.produtos')
                ->get()){
                return response()->json(['mensagem' => 'Não foi possível encontrar a comanda'], 404);
            }


            return response()->json(['comanda' => $comanda], 201);
        }
        catch (Exception $e)
        {
            Log::error($e);
            return response()->json(['mensagem' => 'Não foi possível encontrar a comanda'], 500);
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
            if(!$comanda = Comanda::find($id)){
                return response()->json(['mensagem' => 'Não foi possível encontrar a comanda'], 404);
            }

            $comanda->fill($request->all());

            $comanda->update();

            return response()->json($comanda, 201);
        }
        catch (Exception $e)
        {
            Log::error($e);
            return response()->json(['mensagem' =>'Não foi possível atualizar a comanda'], 500);
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
            if(!$comanda = Comanda::find($id)){
                return response()->json(['mensagem' => 'Não foi possível encontrar a comanda'], 404);
            }

            $comanda->delete();

            return response()->json($comanda, 201);
        }
        catch (Exception $e)
        {
            Log::error($e);
            return response()->json(['mensagem' => 'Não foi possível deletar a comanda'], 500);
        }
    }

    public function comanda_abertas()
    {
        return response()->json(Comanda::where('status', 'aberta')->with('mesas')->get(), 200);
    }

    public function comanda_with_mesas()
    {
        return response()->json(Comanda::with('mesas')->get(), 200);
    }

    public function comandas_notificacoes()
    {
        $notificacoes = Comanda::with('mesas')
            ->where('status', 'fechada')
            // ->whereDate('updated_at', Carbon::today())
            ->where('updated_at', '>=', Carbon::now()->subMinute(10))
            ->get();
        return response()->json($notificacoes, 200);
    }

    public function comanda_mesa_itens()
    {
        try
        {
            $comanda_mesa_itens = Comanda::where('status', 'aberta')
                ->with('mesas')
                ->with('itens_comandas')
                ->with('itens_comandas.produtos')
                ->get();

            if(count($comanda_mesa_itens) <= 0 ){
                return response()->json(['mensagem' => 'Não há nenhuma comanda em aberto'], 404);
            }

            return response()->json($comanda_mesa_itens, 200);
        }catch (Exception $e)
        {
            Log::error($e);
            return response()->json(['mensagem' => 'Não foi possível encontrar a comanda'], 500);
        }
    }
}
