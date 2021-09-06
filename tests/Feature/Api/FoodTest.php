<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Food;

use App\Models\FoodType;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FoodTest extends TestCase
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
    public function it_gets_foods_list()
    {
        $foods = Food::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.foods.index'));

        $response->assertOk()->assertSee($foods[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_food()
    {
        $data = Food::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.foods.store'), $data);

        $this->assertDatabaseHas('foods', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_food()
    {
        $food = Food::factory()->create();

        $foodType = FoodType::factory()->create();

        $data = [
            'name' => $this->faker->name,
            'food_type_id' => $foodType->id,
        ];

        $response = $this->putJson(route('api.foods.update', $food), $data);

        $data['id'] = $food->id;

        $this->assertDatabaseHas('foods', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_food()
    {
        $food = Food::factory()->create();

        $response = $this->deleteJson(route('api.foods.destroy', $food));

        $this->assertDeleted($food);

        $response->assertNoContent();
    }
}
