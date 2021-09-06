<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\MealType;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MealTypeTest extends TestCase
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
    public function it_gets_meal_types_list()
    {
        $mealTypes = MealType::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.meal-types.index'));

        $response->assertOk()->assertSee($mealTypes[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_meal_type()
    {
        $data = MealType::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.meal-types.store'), $data);

        $this->assertDatabaseHas('meal_types', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_meal_type()
    {
        $mealType = MealType::factory()->create();

        $data = [
            'name' => $this->faker->name,
        ];

        $response = $this->putJson(
            route('api.meal-types.update', $mealType),
            $data
        );

        $data['id'] = $mealType->id;

        $this->assertDatabaseHas('meal_types', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_meal_type()
    {
        $mealType = MealType::factory()->create();

        $response = $this->deleteJson(
            route('api.meal-types.destroy', $mealType)
        );

        $this->assertDeleted($mealType);

        $response->assertNoContent();
    }
}
