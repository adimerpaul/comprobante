<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UnidSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('detalles')->insert([
            ['nombre'=>'Sistemas'],
            ['nombre'=>'Espectaculos Publicos'],
            ]);
    }
}
