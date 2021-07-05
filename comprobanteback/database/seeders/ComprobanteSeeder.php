<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComprobanteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('comprobantes')->insert([
            [
                'nrotramite'=>'ADM00001',
                'nrocomprobante'=>'139044',
                'fecha'=>'2021-05-26',
//                'paterno'=>'TERRAZAS',
//                'materno'=>'IRIARTE',
//                'nombres'=>'MARCELA',
//                'direccion'=>'AVENIDA DEL MAESTRO y JUAN LECHIN OQUENDO',
//                'numero'=>'',
//                'ci'=>'3110674',
//                'expedido'=>'OR',
//                'telefono'=>'',
                'tipo'=>'VARIOS',
                'codigo'=>'',
                'valorcatastral'=>'',
                'mtsfrte'=>'',
                'placa'=>'',
                'marca'=>'',
                'modelo'=>'',
                'padron'=>'',
                'capital'=>'',
                'varios'=>'PMC 1-386-26617',
                'tipopago'=>'FECTIVO',
                'banco'=>'',
                'banconro'=>'',
                'intere'=>'',
                'multa'=>'',
                'otros'=>'',
                'formulario'=>'',
                'total'=>'27',
                'literal'=>'VEINTI SIETE 00/100 Bs',
                'controlinterno'=>'13904426/05/2021',
                'estado'=>'CREADO',
                'cajero'=>'',
                'user_id'=>'1',
                'cliente_id'=>'1',
            ]
        ]);
    }
}
