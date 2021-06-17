<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DetalleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('detalles')->insert([
            [
                'coditem'=>'1220007',
                'nombreitem'=>'',
                'codsubitem'=>'1220007',
                'nombresubitem'=>'VENTA Y REPOSICION DE FORMULARIOS',
                'subtotal'=>'2',
                'comprobante_id'=>'1',
            ],
            [
                'coditem'=>'1510015',
                'nombreitem'=>'DERECHO VARIOS',
                'codsubitem'=>'1510015',
                'nombresubitem'=>'VENTA Y REPOSICION DE FORMULARIOS',
                'subtotal'=>'2',
                'comprobante_id'=>'1',
            ],
        ]);
    }
}
