<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Stock;

use App\Models\Company;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StockTest extends TestCase
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
    public function it_gets_stocks_list()
    {
        $stocks = Stock::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.stocks.index'));

        $response->assertOk()->assertSee($stocks[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_stock()
    {
        $data = Stock::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.stocks.store'), $data);

        $this->assertDatabaseHas('stocks', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_stock()
    {
        $stock = Stock::factory()->create();

        $company = Company::factory()->create();

        $data = [
            'name' => $this->faker->name,
            'price' => $this->faker->randomFloat(2, 0, 9999),
            'quantity' => $this->faker->randomNumber(2),
            'total' => $this->faker->randomFloat(2, 0, 9999),
            'stock' => $this->faker->randomNumber(2),
            'company_id' => $company->id,
        ];

        $response = $this->putJson(route('api.stocks.update', $stock), $data);

        $data['id'] = $stock->id;

        $this->assertDatabaseHas('stocks', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_stock()
    {
        $stock = Stock::factory()->create();

        $response = $this->deleteJson(route('api.stocks.destroy', $stock));

        $this->assertDeleted($stock);

        $response->assertNoContent();
    }
}
