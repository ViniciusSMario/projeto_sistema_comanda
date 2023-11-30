<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categorias = [
            'Pizzas',
            'Lanches',
            'Lanches Naturais',
            'Bebidas',
            'Salgados',
            'Sobremesas',
            'Porções',
            'Hot Dog'
        ];

        foreach ($categorias as $value) {
            DB::table('categorias')->insert([
                'nome' => $value
            ]);
        };
    }
}
