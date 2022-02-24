<?php

namespace Database\Seeders;

use App\Models\Cadastros\Usina;
use Illuminate\Database\Seeder;

class UsinaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $usinas = [
            'Granol (TO)',
            'Unibrás (PI)',
            'Olfar'
        ];

        foreach ($usinas as $index => $usina) {
            Usina::create([
                "user_id" => 1,
                "name" => $usina
            ]);
        }

        //Usina::factory()->time(3)->create();
    }
}
