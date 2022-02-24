<?php

namespace Database\Seeders;

use App\Models\Cadastros\Armazem;
use Illuminate\Database\Seeder;

class ArmazensSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $armazens = [
            'Ultra SLZ',
            'Granel SLZ',
            'Granel THE'
        ];

        foreach ($armazens as $index => $armazem) {
            Armazem::create([
                "user_id" => 1,
                "name" => $armazem
            ]);
        }
    }
}
