<?php

namespace Database\Factories;

use App\Models\Menu;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class MenuFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Menu::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'menu_starts' => $this->faker->dateTime,
            'validity' => $this->faker->randomNumber(0),
            'menu_types_id' => \App\Models\MenuTypes::factory(),
            'meal_type_id' => \App\Models\MealType::factory(),
            'food_id' => \App\Models\Food::factory(),
            'company_id' => \App\Models\Company::factory(),
        ];
    }
}
