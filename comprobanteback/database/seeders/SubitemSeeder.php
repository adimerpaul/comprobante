<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubitemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('subitem')->insert([
           [
               'codigo'=>"",
                'nombre'=>"",
                'detalle'=>"",
                'monto'=>"",
                'item_id'=>"",
                'unid_id'=>"",
           ]
        ]);
    }
}
