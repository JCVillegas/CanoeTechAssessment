<?php

namespace Database\Seeders;

use App\Models\Fund;
use Illuminate\Database\Seeder;

class FundSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Fund::create([
            'name'       => 'Sample Fund 1',
            'start_year' => 2000,
            'manager'    => 'Manager Test',
            'alias'      => ['Alias1', 'Alias2', 'Alias3']
        ]);

        Fund::create([
            'name'       => 'Sample Fund 2',
            'start_year' => 2023,
            'manager'    => 'Manager Test2',
            'alias'      => ['Alias4', 'Alias5', 'Alias6']

        ]);
    }
}
