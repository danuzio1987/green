<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'first_name' => "Danúzio",
            'last_name' => 'Ferreira',
            'email' => 'contato@danuzioferreira.com.br',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);
        $user->profile()->create([
            "user_id" => $user->id,
            "avatar" => "default.jpg",
            "function" => "Contador",
            "gender" => "male",
            "birthdate" => date("Y-m-d", strtotime("1987-01-04"))
        ]);
        //User::factory()->times(1)->create();
    }
}
