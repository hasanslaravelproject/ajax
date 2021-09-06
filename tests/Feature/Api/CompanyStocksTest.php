<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Stock;
use App\Models\Company;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CompanyStocksTest extends TestCase
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
    public function it_gets_company_stocks()
    {
        $company = Company::factory()->create();
        $stocks = Stock::factory()
            ->count(2)
            ->create([
                'company_id' => $company->id,
            ]);

        $response = $this->getJson(
            route('api.companies.stocks.index', $company)
        );

        $response->assertOk()->assertSee($stocks[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_company_stocks()
    {
        $company = Company::factory()->create();
        $data = Stock::factory()
            ->make([
                'company_id' => $company->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.companies.stocks.store', $company),
            $data
        );

        $this->assertDatabaseHas('stocks', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $stock = Stock::latest('id')->first();

        $this->assertEquals($company->id, $stock->company_id);
    }
}
