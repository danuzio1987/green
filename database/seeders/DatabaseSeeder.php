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
        $this->call(UsersSeeder::class);
        $this->call(UsinaSeeder::class);
        $this->call(ArmazensSeeder::class);
        $this->call(InsumosSeeder::class);
        $this->call(RolesSeeder::class);
        $this->call(PermissionsSeeder::class);
    }
}
