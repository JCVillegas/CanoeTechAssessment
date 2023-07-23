<?php

namespace Database\Seeders;

use App\Models\FundManager;
use Illuminate\Database\Seeder;

class FundManagerSeeder extends Seeder
{
    public function run(): void
    {
        FundManager::create(['name' => 'Manager Test 1']);
        FundManager::create(['name' => 'Manager Test 2']);
    }
}
