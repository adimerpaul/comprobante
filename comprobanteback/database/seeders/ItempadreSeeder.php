<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItempadreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('itempadres')->insert([
            ['codigo'=>'122','nombre'=> 'VENTA DE SERVICIO DE LAS ADMINISTRACIONES'],
            ['codigo'=>'1331','nombre'=> 'IMPUESTO A LA PROPIEDAD DE BIENES INMUEBLES'],
            ['codigo'=>'1333','nombre'=> 'IMPUESTO A LA PROPIEDAD DE VEHICULOS'],
            ['codigo'=>'1336','nombre'=> 'IMPUESTO MUNICIPAL A LA TRANFERENCIA DE'],
            ['codigo'=>'1337','nombre'=> 'IMPUESTO MUNICIPAL A LA TRANFERENCIA'],
            ['codigo'=>'141','nombre'=> 'REGALIAS MINERAS'],
            ['codigo'=>'151','nombre'=> 'TASAS'],
            ['codigo'=>'1534','nombre'=> 'PATENTES MUNICIPALES'],
            ['codigo'=>'1591','nombre'=> 'MULTAS'],
            ['codigo'=> '1592','nombre'=> 'INTERESES PENALES'],
            ['codigo'=> '1599','nombre'=> 'OTROS INGRESOS NO ESPECIFICOS'],
            ['codigo'=> '163','nombre'=> 'ALQUILER DE EDIFICIOS,TIERRAS Y TERRENOS'],
            ['codigo'=> '3511','nombre' =>'DISMUNICION DE CAJAS Y BANCO'],
        ]);
    }
}
