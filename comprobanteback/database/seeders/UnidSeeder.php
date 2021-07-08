<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnidSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('unids')->insert([
            ['nombre'=>'CATASTRO URBANO','codigo'=>'01','inicio'=>1,'fin'=>100],
            ['nombre'=>'CENTRO IMAGENOLOGIA','codigo'=>'02','inicio'=>1,'fin'=>100],
            ['nombre'=>'INDUSTRIA Y COMERCIO','codigo'=>'03','inicio'=>1,'fin'=>100],
            ['nombre'=>'ESPECTACULOS PUBLICOS','codigo'=>'04','inicio'=>1,'fin'=>100],
            ['nombre'=>'CONTROL MERCADOS','codigo'=>'05','inicio'=>1,'fin'=>100],
            ['nombre'=>'REGULACION URBANA','codigo'=>'06','inicio'=>1,'fin'=>100],
            ['nombre'=>'CEMENTERIO GENERAL','codigo'=>'07','inicio'=>1,'fin'=>100],
            ['nombre'=>'REGULACION URBANA DISTRITO 3','codigo'=>'08','inicio'=>1,'fin'=>100],
            ['nombre'=>'ARBITRIOS MUNICIPALES','codigo'=>'09','inicio'=>1,'fin'=>100],
            ['nombre'=>'UNIDAD VALORES','codigo'=>'10','inicio'=>1,'fin'=>100],
            ['nombre'=>'DIRECCION TRAFICO y VIALIDAD','codigo'=>'11','inicio'=>1,'fin'=>100],
            ['nombre'=>'COACTIVA','codigo'=>'12','inicio'=>1,'fin'=>100],
            ['nombre'=>'DIRECCION CASA MUNICIPAL DE CULTURA','codigo'=>'13','inicio'=>1,'fin'=>100],
            ['nombre'=>'DIRECCION PP SALUD','codigo'=>'14','inicio'=>1,'fin'=>100],
            ['nombre'=>'REGISTRO UNICO AUTOMOTOR','codigo'=>'15','inicio'=>1,'fin'=>100],
            ['nombre'=>'UNIDAD SISTEMA','codigo'=>'16','inicio'=>1,'fin'=>100],
            ]);
    }
}
