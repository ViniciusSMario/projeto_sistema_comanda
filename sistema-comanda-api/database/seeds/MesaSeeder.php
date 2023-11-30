<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MesaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mesas = [
            'Mesa 1',
            'Mesa 2',
            'Mesa 3',
            'Mesa 4',
            'Mesa 5',
            'Mesa 6',
            'Mesa 7',
            'Mesa 8',
            'Mesa 9',
            'Mesa 10'
        ];

        foreach ($mesas as $value) {
            DB::table('mesas')->insert([
                'nome' => $value
            ]);
        }
    }
}
