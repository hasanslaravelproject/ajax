<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\FoodType;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FoodTypeControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_food_types()
    {
        $foodTypes = FoodType::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('food-types.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.food_types.index')
            ->assertViewHas('foodTypes');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_food_type()
    {
        $response = $this->get(route('food-types.create'));

        $response->assertOk()->assertViewIs('app.food_types.create');
    }

    /**
     * @test
     */
    public function it_stores_the_food_type()
    {
        $data = FoodType::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('food-types.store'), $data);

        $this->assertDatabaseHas('food_types', $data);

        $foodType = FoodType::latest('id')->first();

        $response->assertRedirect(route('food-types.edit', $foodType));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_food_type()
    {
        $foodType = FoodType::factory()->create();

        $response = $this->get(route('food-types.show', $foodType));

        $response
            ->assertOk()
            ->assertViewIs('app.food_types.show')
            ->assertViewHas('foodType');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_food_type()
    {
        $foodType = FoodType::factory()->create();

        $response = $this->get(route('food-types.edit', $foodType));

        $response
            ->assertOk()
            ->assertViewIs('app.food_types.edit')
            ->assertViewHas('foodType');
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

        $response = $this->put(route('food-types.update', $foodType), $data);

        $data['id'] = $foodType->id;

        $this->assertDatabaseHas('food_types', $data);

        $response->assertRedirect(route('food-types.edit', $foodType));
    }

    /**
     * @test
     */
    public function it_deletes_the_food_type()
    {
        $foodType = FoodType::factory()->create();

        $response = $this->delete(route('food-types.destroy', $foodType));

        $response->assertRedirect(route('food-types.index'));

        $this->assertDeleted($foodType);
    }
}
