<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Food;

use App\Models\FoodType;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FoodControllerTest extends TestCase
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
    public function it_displays_index_view_with_foods()
    {
        $foods = Food::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('foods.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.foods.index')
            ->assertViewHas('foods');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_food()
    {
        $response = $this->get(route('foods.create'));

        $response->assertOk()->assertViewIs('app.foods.create');
    }

    /**
     * @test
     */
    public function it_stores_the_food()
    {
        $data = Food::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('foods.store'), $data);

        $this->assertDatabaseHas('foods', $data);

        $food = Food::latest('id')->first();

        $response->assertRedirect(route('foods.edit', $food));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_food()
    {
        $food = Food::factory()->create();

        $response = $this->get(route('foods.show', $food));

        $response
            ->assertOk()
            ->assertViewIs('app.foods.show')
            ->assertViewHas('food');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_food()
    {
        $food = Food::factory()->create();

        $response = $this->get(route('foods.edit', $food));

        $response
            ->assertOk()
            ->assertViewIs('app.foods.edit')
            ->assertViewHas('food');
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

        $response = $this->put(route('foods.update', $food), $data);

        $data['id'] = $food->id;

        $this->assertDatabaseHas('foods', $data);

        $response->assertRedirect(route('foods.edit', $food));
    }

    /**
     * @test
     */
    public function it_deletes_the_food()
    {
        $food = Food::factory()->create();

        $response = $this->delete(route('foods.destroy', $food));

        $response->assertRedirect(route('foods.index'));

        $this->assertDeleted($food);
    }
}
