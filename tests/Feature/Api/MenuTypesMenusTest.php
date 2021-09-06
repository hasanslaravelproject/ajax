<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Menu;
use App\Models\MenuTypes;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MenuTypesMenusTest extends TestCase
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
    public function it_gets_menu_types_menus()
    {
        $menuTypes = MenuTypes::factory()->create();
        $menus = Menu::factory()
            ->count(2)
            ->create([
                'menu_types_id' => $menuTypes->id,
            ]);

        $response = $this->getJson(
            route('api.all-menu-types.menus.index', $menuTypes)
        );

        $response->assertOk()->assertSee($menus[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_menu_types_menus()
    {
        $menuTypes = MenuTypes::factory()->create();
        $data = Menu::factory()
            ->make([
                'menu_types_id' => $menuTypes->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.all-menu-types.menus.store', $menuTypes),
            $data
        );

        $this->assertDatabaseHas('menus', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $menu = Menu::latest('id')->first();

        $this->assertEquals($menuTypes->id, $menu->menu_types_id);
    }
}
