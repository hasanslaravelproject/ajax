<?php

namespace Database\Seeders;

use App\Models\MenuTypes;
use Illuminate\Database\Seeder;

class MenuTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MenuTypes::factory()
            ->count(5)
            ->create();
    }
}
