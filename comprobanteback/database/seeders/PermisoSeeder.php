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
            ["nombre"=>"Contributente"],
            ["nombre"=>"Usuarios"],
            ["nombre"=>"Item"],
            ["nombre"=>"Unidades"],
            ["nombre"=>"Comprobante"],
            ["nombre"=>"Imprimir comprobante"],
            ["nombre"=>"Pagos comprobante"],
            ["nombre"=>"Empresa"],
//            ["nombre"=>"Contributente"],
//            ["nombre"=>"Contributente"],
//            ["nombre"=>"Contributente"],
        ]);
    }
}
