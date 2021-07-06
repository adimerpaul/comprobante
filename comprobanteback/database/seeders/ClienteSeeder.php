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
                'padron'=>'1-11-1111'
            ],
            [
                'ci'=>'2736635',
                'expedido'=>'OR',
                'paterno'=>'PACHECO',
                'materno'=>'PINTO',
                'nombre'=>'VICTOR PABLO',
                'casada'=>'',
                'direccion'=>'CALLE X',
                'numcasa'=>'12',
                'telefono'=>'',
                'padron'=>'1-11-1155'
            ],
            [
                'ci'=>'2020',
                'expedido'=>'OR',
                'paterno'=>'LOPEZ',
                'materno'=>'GUTIERREZ',
                'nombre'=>'ALEJANDRO',
                'casada'=>'',
                'direccion'=>'CALLE Y',
                'numcasa'=>'12',
                'telefono'=>'5261245',
                'padron'=>'1-11-1111'
            ],
        ]);
    }
}
