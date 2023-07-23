<?php

namespace Tests\Unit\Database;

use App\Models\Company;
use App\Models\Fund;
use App\Models\FundManager;
use Tests\TestCase;

class FundCompanyTest extends TestCase
{
    //use RefreshDatabase; // This trait resets the database after each test case

    /** @test */
    public function can_create_a_fund_company_relationship()
    {

        $fundManager = FundManager::create([
            'name' => 'Test Fund Manager',
        ]);


        $fund = Fund::create([
            'name' => 'Test Fund',
            'start_year' => 2023,
            'manager_id' => $fundManager->id,
            'aliases' => ['alias1', 'alias2', 'alias3']
        ]);

        $company = Company::create([
            'name' => 'Test Company',

        ]);

        // Create the fund_company relationship
        $fund->companies()->attach($company);

        // Assert - check if the relationship was created successfully in the database
        $this->assertDatabaseHas('fund_company', [
            'fund_id' => $fund->id,
            'company_id' => $company->id,
        ]);
    }
}

