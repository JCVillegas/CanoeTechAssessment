<?php

namespace Database\Seeders;

use App\Models\Fund;
use App\Models\FundManager;
use Illuminate\Database\Seeder;

class FundSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $manager1 = FundManager::where('name', 'Manager Test 1')->firstOrFail();

        Fund::create([
            'name'         => 'Sample Fund 1',
            'start_year'   => 2000,
            'manager_id'   => $manager1->id,
            'aliases'      => ['Alias1', 'Alias2', 'Alias3']
        ]);

        $manager2 = FundManager::where('name', 'Manager Test 2')->firstOrFail();
        Fund::create([
            'name'         => 'Sample Fund 2',
            'start_year'   => 2023,
            'manager_id'   => $manager2->id,
            'aliases'      => ['Alias4', 'Alias5', 'Alias6']

        ]);
    }
}
