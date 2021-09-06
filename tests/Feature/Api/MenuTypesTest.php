<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\MenuTypes;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MenuTypesTest extends TestCase
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
    public function it_gets_all_menu_types_list()
    {
        $allMenuTypes = MenuTypes::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.all-menu-types.index'));

        $response->assertOk()->assertSee($allMenuTypes[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_menu_types()
    {
        $data = MenuTypes::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.all-menu-types.store'), $data);

        $this->assertDatabaseHas('menu_types', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_menu_types()
    {
        $menuTypes = MenuTypes::factory()->create();

        $data = [
            'name' => $this->faker->name,
        ];

        $response = $this->putJson(
            route('api.all-menu-types.update', $menuTypes),
            $data
        );

        $data['id'] = $menuTypes->id;

        $this->assertDatabaseHas('menu_types', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_menu_types()
    {
        $menuTypes = MenuTypes::factory()->create();

        $response = $this->deleteJson(
            route('api.all-menu-types.destroy', $menuTypes)
        );

        $this->assertDeleted($menuTypes);

        $response->assertNoContent();
    }
}
