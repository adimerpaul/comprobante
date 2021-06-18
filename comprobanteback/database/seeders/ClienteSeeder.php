<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('clientes')->insert([
            [
                'ci'=>'1010',
                'expedido'=>'OR',
                'paterno'=>'CHAMBI',
                'materno'=>'AJATA',
                'nombre'=>'ADIMER',
                'casada'=>'',
                'direccion'=>'CALLE X',
                'numcasa'=>'12',
                'telefono'=>'5261245',
            ]
        ]);
    }
}
