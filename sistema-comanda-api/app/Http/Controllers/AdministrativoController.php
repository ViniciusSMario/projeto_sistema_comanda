<?php

namespace App\Http\Controllers;

use App\Categoria;
use App\Comanda;
use App\Mesa;
use App\Produto;
use App\TipoPagamento;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdministrativoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dados_gerais = [];
        $dados_gerais['aberta']['geral']['qtde'] = Comanda::where('status', 'aberta')->count();
        $dados_gerais['aberta']['hoje']['qtde'] = Comanda::where('status', 'aberta')->whereDate('created_at', Carbon::now())->count();

        $dados_gerais['aberta']['geral']['valor_total'] = floatval(Comanda::join('fechamentos', 'fechamentos.comandas_id', 'comandas.id')
                                                            ->where('comandas.status', 'aberta')->sum('fechamentos.valor_total'));

        $dados_gerais['aberta']['hoje']['valor_total'] = floatval(Comanda::join('fechamentos', 'fechamentos.comandas_id', 'comandas.id')
                                                            ->where('comandas.status', 'aberta')
                                                            ->whereDate('comandas.created_at', Carbon::now())
                                                            ->sum('fechamentos.valor_total'));

        $dados_gerais['fechada']['geral']['qtde'] = Comanda::where('status', 'fechada')->count();
        $dados_gerais['fechada']['hoje']['qtde'] = Comanda::where('status', 'fechada')->whereDate('created_at', Carbon::now())->count();

        $dados_gerais['fechada']['geral']['valor_total'] = floatval(Comanda::join('fechamentos', 'fechamentos.comandas_id', 'comandas.id')
                                                            ->where('comandas.status', 'fechada')
                                                            ->sum('fechamentos.valor_total'));

        $dados_gerais['fechada']['hoje']['valor_total'] = floatval(Comanda::join('fechamentos', 'fechamentos.comandas_id', 'comandas.id')
                                                            ->where('comandas.status', 'fechada')
                                                            ->whereDate('comandas.created_at', Carbon::now())
                                                            ->sum('fechamentos.valor_total'));

        $dados_gerais['total_comandas']['geral']['qtde'] = intval($dados_gerais['fechada']['geral']['qtde']) + intval($dados_gerais['aberta']['geral']['qtde']);
        $dados_gerais['total_comandas']['hoje']['qtde'] = intval($dados_gerais['fechada']['hoje']['qtde']) + intval($dados_gerais['aberta']['hoje']['qtde']);

        $dados_gerais['total_comandas']['geral']['valor_total'] = floatval($dados_gerais['fechada']['geral']['valor_total']) + floatval($dados_gerais['aberta']['geral']['valor_total']);
        $dados_gerais['total_comandas']['hoje']['valor_total'] = floatval($dados_gerais['fechada']['hoje']['valor_total']) + floatval($dados_gerais['aberta']['hoje']['valor_total']);


        $dados_gerais['mesas'] = Mesa::count();
        $dados_gerais['produtos'] = Produto::count();
        $dados_gerais['categorias'] = Categoria::count();
        $dados_gerais['pagamentos'] = TipoPagamento::count();


        return response()->json($dados_gerais);
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
