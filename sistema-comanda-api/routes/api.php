<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/administrativo')->group(function(){
    Route::get('/', 'AdministrativoController@index');
});

Route::prefix('/categorias')->group(function(){
    Route::get('/', 'CategoriaController@index');
    Route::get('/{id}', 'CategoriaController@show');
    Route::post('/', 'CategoriaController@store');
    Route::put('/{id}', 'CategoriaController@update');
    Route::delete('/{id}', 'CategoriaController@destroy');
});

Route::prefix('/produtos')->group(function(){
    Route::get('/', 'ProdutoController@index');
    Route::get('/{id}', 'ProdutoController@show');
    Route::get('/categoria/{id}', 'ProdutoController@show_by_categoria');
    Route::post('/', 'ProdutoController@store');
    Route::put('/{id}', 'ProdutoController@update');
    Route::delete('/{id}', 'ProdutoController@destroy');
    Route::post('/filtro', 'ProdutoController@produtosFiltrados');
});

Route::prefix('/mesas')->group(function(){
    Route::get('/', 'MesaController@index');
    Route::get('/disponiveis', 'MesaController@disponiveis');
    Route::get('/indisponiveis', 'MesaController@indisponiveis');
    Route::get('/{id}', 'MesaController@show');
    Route::post('/', 'MesaController@store');
    Route::put('/{id}', 'MesaController@update');
    Route::delete('/{id}', 'MesaController@destroy');
});

Route::prefix('/tipo_pagamentos')->group(function(){
    Route::get('/', 'TipoPagamentoController@index');
    Route::get('/{id}', 'TipoPagamentoController@show');
    Route::post('/', 'TipoPagamentoController@store');
    Route::put('/{id}', 'TipoPagamentoController@update');
    Route::delete('/{id}', 'TipoPagamentoController@destroy');
});

Route::prefix('/comandas')->group(function(){
    Route::get('/abertas', 'ComandaController@comanda_abertas');
    Route::get('/', 'ComandaController@index');
    Route::get('/{id}', 'ComandaController@show');
    Route::get('/mesas/{id}', 'ComandaController@comanda_with_mesa');
    Route::get('/with/mesas', 'ComandaController@comanda_with_mesas');
    Route::get('/itens/{id}', 'ComandaController@comanda_with_itens');
    Route::get('/mesa/itens/', 'ComandaController@comanda_mesa_itens');
    Route::get('/mesa/notificacoes', 'ComandaController@comandas_notificacoes');
    Route::post('/', 'ComandaController@store');
    Route::put('/{id}', 'ComandaController@update');
    Route::delete('/{id}', 'ComandaController@destroy');
});

Route::prefix('/itens_comandas')->group(function(){
    Route::get('/', 'ItensComandaController@index');
    Route::get('/{id}', 'ItensComandaController@show');
    Route::post('/', 'ItensComandaController@store');
    Route::put('/{id}', 'ItensComandaController@update');
    Route::delete('/{id}', 'ItensComandaController@destroy');
});

Route::prefix('/fechamentos')->group(function(){
    Route::get('/', 'FechamentoController@index');
    Route::get('/{id}', 'FechamentoController@show');
    Route::post('/', 'FechamentoController@store');
    Route::put('/{id}', 'FechamentoController@update');
    Route::delete('/{id}', 'FechamentoController@destroy');
});
