<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\MenuTypes;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MenuTypesControllerTest extends TestCase
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
    public function it_displays_index_view_with_all_menu_types()
    {
        $allMenuTypes = MenuTypes::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('all-menu-types.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.all_menu_types.index')
            ->assertViewHas('allMenuTypes');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_menu_types()
    {
        $response = $this->get(route('all-menu-types.create'));

        $response->assertOk()->assertViewIs('app.all_menu_types.create');
    }

    /**
     * @test
     */
    public function it_stores_the_menu_types()
    {
        $data = MenuTypes::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('all-menu-types.store'), $data);

        $this->assertDatabaseHas('menu_types', $data);

        $menuTypes = MenuTypes::latest('id')->first();

        $response->assertRedirect(route('all-menu-types.edit', $menuTypes));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_menu_types()
    {
        $menuTypes = MenuTypes::factory()->create();

        $response = $this->get(route('all-menu-types.show', $menuTypes));

        $response
            ->assertOk()
            ->assertViewIs('app.all_menu_types.show')
            ->assertViewHas('menuTypes');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_menu_types()
    {
        $menuTypes = MenuTypes::factory()->create();

        $response = $this->get(route('all-menu-types.edit', $menuTypes));

        $response
            ->assertOk()
            ->assertViewIs('app.all_menu_types.edit')
            ->assertViewHas('menuTypes');
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

        $response = $this->put(
            route('all-menu-types.update', $menuTypes),
            $data
        );

        $data['id'] = $menuTypes->id;

        $this->assertDatabaseHas('menu_types', $data);

        $response->assertRedirect(route('all-menu-types.edit', $menuTypes));
    }

    /**
     * @test
     */
    public function it_deletes_the_menu_types()
    {
        $menuTypes = MenuTypes::factory()->create();

        $response = $this->delete(route('all-menu-types.destroy', $menuTypes));

        $response->assertRedirect(route('all-menu-types.index'));

        $this->assertDeleted($menuTypes);
    }
}
