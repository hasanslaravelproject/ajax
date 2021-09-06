<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Food;
use App\Models\FoodType;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FoodTypeFoodsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['email' => 'admin@admin.com']);

        Sanctum::actingAs($user, [], 'web');

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_food_type_foods()
    {
        $foodType = FoodType::factory()->create();
        $foods = Food::factory()
            ->count(2)
            ->create([
                'food_type_id' => $foodType->id,
            ]);

        $response = $this->getJson(
            route('api.food-types.foods.index', $foodType)
        );

        $response->assertOk()->assertSee($foods[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_food_type_foods()
    {
        $foodType = FoodType::factory()->create();
        $data = Food::factory()
            ->make([
                'food_type_id' => $foodType->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.food-types.foods.store', $foodType),
            $data
        );

        $this->assertDatabaseHas('foods', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $food = Food::latest('id')->first();

        $this->assertEquals($foodType->id, $food->food_type_id);
    }
}
