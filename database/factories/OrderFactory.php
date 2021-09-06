<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'delivery_date' => $this->faker->dateTime,
            'order_quantity' => $this->faker->randomNumber,
            'customer_id' => \App\Models\Customer::factory(),
            'menu_id' => \App\Models\Menu::factory(),
        ];
    }
}
