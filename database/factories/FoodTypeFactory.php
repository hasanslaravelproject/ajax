<?php

namespace Database\Factories;

use App\Models\FoodType;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class FoodTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FoodType::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
        ];
    }
}
