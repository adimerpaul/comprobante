<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermisoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permisos')->insert([
            ["id"=>1,"nombre"=>"Contributente"],
            ["id"=>2,"nombre"=>"Usuarios"],
            ["id"=>3,"nombre"=>"Item"],
            ["id"=>4,"nombre"=>"Unidades"],
            ["id"=>5,"nombre"=>"Comprobante"],
            ["id"=>6,"nombre"=>"Imprimir comprobante"],
            ["id"=>7,"nombre"=>"Pagos comprobante"],
            ["id"=>8,"nombre"=>"Empresa"],
            ["id"=>9,"nombre"=>"Verificar pagos"],
            ["id"=>10,"nombre"=>"Pagos caja"],
            ["id"=>11,"nombre"=>"Anular comprobante"],
            ["id"=>12,"nombre"=>"Resumen Dia"],
//            ["nombre"=>"Contributente"],
//            ["nombre"=>"Contributente"],
//            ["nombre"=>"Contributente"],
        ]);
    }
}
