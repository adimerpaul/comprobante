<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Cliente_empresa extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cliente_empresa')->insert([
            [
                'cliente_id'=>1,
                'empresa_id'=>1
            ],
            [
                'cliente_id'=>2,
                'empresa_id'=>1
            ],
            [
                'cliente_id'=>1,
                'empresa_id'=>2
            ],
            [
                'cliente_id'=>1,
                'empresa_id'=>3
            ],
        ]);
    }
}
