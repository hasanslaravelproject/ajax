<?php

namespace Database\Factories;

use App\Models\Stock;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class StockFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Stock::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'price' => $this->faker->randomFloat(2, 0, 9999),
            'quantity' => $this->faker->randomNumber(2),
            'total' => $this->faker->randomFloat(2, 0, 9999),
            'stock' => $this->faker->randomNumber(2),
            'company_id' => \App\Models\Company::factory(),
        ];
    }
}
