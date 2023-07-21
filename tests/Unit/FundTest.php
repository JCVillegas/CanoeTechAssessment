<?php

namespace Tests\Unit;



use App\Models\Fund;
use App\Models\FundManager;
use Tests\TestCase;

class FundTest extends TestCase
{
    /** @test */
    public function can_create_a_fund()
    {
        $fundManager = FundManager::create([
            'name' => 'Test Fund Manager',
        ]);

        $fund = Fund::create([
            'name' => 'Test Fund',
            'start_year' => 2023,
            'manager_id' => $fundManager->id, // Use the ID of the existing Fund Manager
        ]);

        $this->assertInstanceOf(Fund::class, $fund);
        $this->assertEquals('Test Fund', $fund->name);

    }


}