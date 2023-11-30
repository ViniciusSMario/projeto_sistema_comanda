<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdutosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $produtos = [
            [
                'Pizza de Frango com catupiry',
                'Pizza de frango desfiado com catupiry',
                29.50,
                1
            ],
            [
                'Pizza de calabresa',
                'Pizza com rodelas de calabresa e catupiry',
                28.90,
                1
            ],
            [
                'Pizza de lombinho',
                'Pizza de lombinho com catupiry',
                25.00,
                1
            ],
            [
                'X-Burger',
                'Pão de hambúrger, hambúrger 90g, maionese e queijo',
                9.50,
                2
            ],
            [
                'X-Salada',
                'Pão de hambúrger, hambúrger 90g, maionese, alface, tomate e queijo',
                10.00,
                2
            ],
            [
                'X-Egg',
                'Pão de hambúrger, hambúger 90g, maionese, tomate, alface, ovo e queijo',
                13.50,
                2
            ],
            [
                'Lanche natural de Frango',
                'Pão de forma, frango desfiado, maionese, tomate, alface, cenoura e queijo',
                13.50,
                3
            ],
            [
                'Coca-Cola',
                'Lata',
                4.00,
                4
            ],
            [
                'Coca-Cola',
                '2 Litros',
                10.00,
                4
            ],
            [
                'Suco de laranja - Copo',
                'Suco natural de laranja sem açúcar',
                4.00,
                4
            ],
            [
                'Suco de abacaxi com hortelã - Copo',
                'Suco natural de abacaxi com hortelã sem açúcar',
                4.50,
                4
            ],
            [
                'Cerveja Brahma',
                'Lata',
                5,
                4
            ],
            [
                'Cerveja Brahma',
                '600 ml',
                7,
                4
            ],
            [
                'Cerveja Skol',
                '600 ml',
                7,
                4
            ],
            [
                'Coxinha de Frango com catupiry',
                'Coxinha de frango desfiado com catupiry',
                4.50,
                5
            ],
            [
                'Coxinha de Frango com cheddar',
                'Coxinha de frango desfiado com cheddar',
                4.50,
                5
            ],
            [
                'Batata frita',
                'Porção de batata frita simples',
                20.00,
                7
            ],
            [
                'Batata frita com cheddar e bacon',
                'Porção de batata frita com cheddar e bacon',
                32.00,
                7
            ]
        ];

        foreach ($produtos as $value) {
            DB::table('produtos')->insert([
                'nome' => $value[0],
                'descricao' => $value[1],
                'preco' => $value[2],
                'categorias_id' => $value[3]
            ]);
        }
    }
}
