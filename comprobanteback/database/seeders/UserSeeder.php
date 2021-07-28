<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
           [
               'email'=>'admin@test.com',
               'name'=>'admin',
               'codigo'=>'ADM',
               'password'=>Hash::make('G4M02021#'),
               'unid_id'=>16
           ],
            [
                'email'=>'c@t.com',
                'name'=>'CELSO ACHOCALLE',
                'codigo'=>'CEL',
                'password'=>Hash::make('#123456789#'),
                'unid_id'=>3
            ],
        ]);
    }
}
