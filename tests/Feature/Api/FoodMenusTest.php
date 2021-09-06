<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Food;
use App\Models\Menu;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FoodMenusTest extends TestCase
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
    public function it_gets_food_menus()
    {
        $food = Food::factory()->create();
        $menus = Menu::factory()
            ->count(2)
            ->create([
                'food_id' => $food->id,
            ]);

        $response = $this->getJson(route('api.foods.menus.index', $food));

        $response->assertOk()->assertSee($menus[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_food_menus()
    {
        $food = Food::factory()->create();
        $data = Menu::factory()
            ->make([
                'food_id' => $food->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.foods.menus.store', $food),
            $data
        );

        $this->assertDatabaseHas('menus', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $menu = Menu::latest('id')->first();

        $this->assertEquals($food->id, $menu->food_id);
    }
}
