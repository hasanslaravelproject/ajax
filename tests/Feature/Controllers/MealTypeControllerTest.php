<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\MealType;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MealTypeControllerTest extends TestCase
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
    public function it_displays_index_view_with_meal_types()
    {
        $mealTypes = MealType::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('meal-types.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.meal_types.index')
            ->assertViewHas('mealTypes');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_meal_type()
    {
        $response = $this->get(route('meal-types.create'));

        $response->assertOk()->assertViewIs('app.meal_types.create');
    }

    /**
     * @test
     */
    public function it_stores_the_meal_type()
    {
        $data = MealType::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('meal-types.store'), $data);

        $this->assertDatabaseHas('meal_types', $data);

        $mealType = MealType::latest('id')->first();

        $response->assertRedirect(route('meal-types.edit', $mealType));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_meal_type()
    {
        $mealType = MealType::factory()->create();

        $response = $this->get(route('meal-types.show', $mealType));

        $response
            ->assertOk()
            ->assertViewIs('app.meal_types.show')
            ->assertViewHas('mealType');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_meal_type()
    {
        $mealType = MealType::factory()->create();

        $response = $this->get(route('meal-types.edit', $mealType));

        $response
            ->assertOk()
            ->assertViewIs('app.meal_types.edit')
            ->assertViewHas('mealType');
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

        $response = $this->put(route('meal-types.update', $mealType), $data);

        $data['id'] = $mealType->id;

        $this->assertDatabaseHas('meal_types', $data);

        $response->assertRedirect(route('meal-types.edit', $mealType));
    }

    /**
     * @test
     */
    public function it_deletes_the_meal_type()
    {
        $mealType = MealType::factory()->create();

        $response = $this->delete(route('meal-types.destroy', $mealType));

        $response->assertRedirect(route('meal-types.index'));

        $this->assertDeleted($mealType);
    }
}
