<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RubroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rubros')->insert([
           [
               "nombre"=>"",
               "monto"=>"28",
               "temporada"=>"FERIA NORTE",
               "categoria"=>"AUTORIZACIÓN Y DERECHO DE SITIAJE POR PUESTO",
           ]
        ]);
    }
}
