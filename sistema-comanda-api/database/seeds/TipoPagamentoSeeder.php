<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoPagamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipoPagamento = [
            'Pix',
            'Cartão de Débito',
            'Cartão de Crédito',
            'Dinheiro',
            'Vale refeição'
        ];

        foreach ($tipoPagamento as $value) {
            DB::table('tipo_pagamentos')->insert([
                'nome' => $value
            ]);
        }
    }
}
