<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermisoUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permiso_user')->insert([
            ['user_id'=>1,'permiso_id'=>1],
            ['user_id'=>1,'permiso_id'=>2],
            ['user_id'=>1,'permiso_id'=>3],
            ['user_id'=>1,'permiso_id'=>4],
            ['user_id'=>1,'permiso_id'=>5],
            ['user_id'=>1,'permiso_id'=>6],
            ['user_id'=>1,'permiso_id'=>7],
            ['user_id'=>1,'permiso_id'=>8],
            ['user_id'=>1,'permiso_id'=>9],
            ['user_id'=>1,'permiso_id'=>10],
            ['user_id'=>1,'permiso_id'=>11],
            ['user_id'=>1,'permiso_id'=>12],
            ['user_id'=>1,'permiso_id'=>13],
            ['user_id'=>1,'permiso_id'=>14],
            ['user_id'=>1,'permiso_id'=>15],
            ['user_id'=>1,'permiso_id'=>16],
            ['user_id'=>1,'permiso_id'=>17],
            ['user_id'=>1,'permiso_id'=>18],
            ['user_id'=>2,'permiso_id'=>5],
            ['user_id'=>2,'permiso_id'=>6],
            ['user_id'=>2,'permiso_id'=>7],
        ]);
    }
}
