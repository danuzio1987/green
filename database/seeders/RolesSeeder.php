<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nomes = [
            "Super Admin",
            "Admin",
            "Diretoria",
            "Operação",
        ];

        foreach ($nomes as $key => $nome) {
            Role::create([
                "name" => $nome
            ]);
        }

        $user = User::findOrFail(1);
        $role = Role::findById(1);
        $user->assignRole($role);

    }
}
