<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('items')->insert([
            [
                'codigo'=>"1220007",
                'nombre'=>"VENTA Y REPOCICION",
                'detalle'=>"",
                'monto'=>"2",
                'unid_id'=>"2",
            ],
            [
                'codigo'=>"1510015",
                'nombre'=>"DERECHOS VARIOS",
                'detalle'=>"",
                'monto'=>"25",
                'unid_id'=>"2",
            ],
        ]);
    }
}
