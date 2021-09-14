<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            UnidSeeder::class,
            UserSeeder::class,
            ClienteSeeder::class,
            ItempadreSeeder::class,
//            DetalleSeeder::class,
            ItemSeeder::class,
            EmpresaSeeder::class,
            Cliente_empresa::class,
            SubitemSeeder::class,
            PermisoSeeder::class,
            PermisoUser::class,
            ItemUnidSeeder::class
        ]);
    }
}
