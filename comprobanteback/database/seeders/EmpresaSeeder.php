<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('empresas')->insert([
           [
               'razonsocial'=>'COCA COLA',
                'direccion'=>'XALLE X',
                'telefono'=>'101010',
                'nit'=>'101010',
                'padron'=>'10-10-101010',
                'cliente_id'=>'2'
           ],
            [
                'razonsocial'=>'PEPSIO',
                'direccion'=>'XALLE X',
                'telefono'=>'101010',
                'nit'=>'101010',
                'padron'=>'10-10-101010',
                'cliente_id'=>'2'
            ],
            [
                'razonsocial'=>'COCA QUINA',
                'direccion'=>'XALLE X',
                'telefono'=>'101010',
                'nit'=>'101010',
                'padron'=>'10-10-101010',
                'cliente_id'=>'2'
            ],
        ]);
    }
}
