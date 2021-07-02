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
            ['nombre'=>'Sistemas','inicio'=>1,'fin'=>100],
            ['nombre'=>'Espectaculos Publicos','inicio'=>1,'fin'=>100],
            ]);
    }
}
