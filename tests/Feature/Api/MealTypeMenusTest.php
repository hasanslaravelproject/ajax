<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Menu;
use App\Models\MealType;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MealTypeMenusTest extends TestCase
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
    public function it_gets_meal_type_menus()
    {
        $mealType = MealType::factory()->create();
        $menus = Menu::factory()
            ->count(2)
            ->create([
                'meal_type_id' => $mealType->id,
            ]);

        $response = $this->getJson(
            route('api.meal-types.menus.index', $mealType)
        );

        $response->assertOk()->assertSee($menus[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_meal_type_menus()
    {
        $mealType = MealType::factory()->create();
        $data = Menu::factory()
            ->make([
                'meal_type_id' => $mealType->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.meal-types.menus.store', $mealType),
            $data
        );

        $this->assertDatabaseHas('menus', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $menu = Menu::latest('id')->first();

        $this->assertEquals($mealType->id, $menu->meal_type_id);
    }
}
