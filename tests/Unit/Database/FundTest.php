<?php

namespace Tests\Unit\Database;



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
            'manager_id' => $fundManager->id,
            'aliases' => ['alias1', 'alias2', 'alias3']
        ]);

        $this->assertInstanceOf(Fund::class, $fund);
        $this->assertEquals('Test Fund', $fund->name);

    }


}


