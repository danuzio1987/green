<?php

namespace Database\Seeders;

use App\Models\Cadastros\Insumo;
use Illuminate\Database\Seeder;

class InsumosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $insumos = [
            'Gasolina A',
            'Anidro',
            'S500 A',
            'S10 A',
            'B100',
            'Hidratado'
        ];

        foreach ($insumos as $index => $insumo) {
            Insumo::create([
                "user_id" => 1,
                "name" => $insumo
            ]);
        }



    }
}
