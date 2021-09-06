<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\FoodType;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FoodTypeTest extends TestCase
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
    public function it_gets_food_types_list()
    {
        $foodTypes = FoodType::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.food-types.index'));

        $response->assertOk()->assertSee($foodTypes[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_food_type()
    {
        $data = FoodType::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.food-types.store'), $data);

        $this->assertDatabaseHas('food_types', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_food_type()
    {
        $foodType = FoodType::factory()->create();

        $data = [
            'name' => $this->faker->name,
        ];

        $response = $this->putJson(
            route('api.food-types.update', $foodType),
            $data
        );

        $data['id'] = $foodType->id;

        $this->assertDatabaseHas('food_types', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_food_type()
    {
        $foodType = FoodType::factory()->create();

        $response = $this->deleteJson(
            route('api.food-types.destroy', $foodType)
        );

        $this->assertDeleted($foodType);

        $response->assertNoContent();
    }
}
