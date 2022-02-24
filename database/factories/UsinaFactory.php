<?php

namespace Database\Factories;

use App\Models\Cadastros\Usina;
use Illuminate\Database\Eloquent\Factories\Factory;

class UsinaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Usina::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
                'user_id' => 1,
                'name' => $this->faker->text(5)
            ];
        }
}
