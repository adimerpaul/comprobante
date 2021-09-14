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
            ["id"=>7,"nombre"=>"Anular comprobante"],
            ["id"=>8,"nombre"=>"Pagos comprobante"],
            ["id"=>9,"nombre"=>"Pagos caja"],
            ["id"=>10,"nombre"=>"Resumen Dia"],
            ["id"=>11,"nombre"=>"Empresa"],
            ["id"=>12,"nombre"=>"Exportar"],
            ["id"=>13,"nombre"=>"Importar"],

            ["id"=>14,"nombre"=>"Verificar"],
            ["id"=>15,"nombre"=>"Verificar en Caja"],
            ["id"=>16,"nombre"=>"Verificar en Sistema"],
            ["id"=>17,"nombre"=>"Mis items"],
            ["id"=>18,"nombre"=>"ACtualizar comprobante"],
//            ["nombre"=>"Contributente"],
//            ["nombre"=>"Contributente"],
//            ["nombre"=>"Contributente"],
        ]);
    }
}
