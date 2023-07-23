<?php

namespace Tests\Unit\Controllers;

use App\Models\Fund;
use Database\Seeders\FundManagerSeeder;
use Database\Seeders\FundSeeder;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;


class ApiFundControllerTest extends TestCase
{
    use RefreshDatabase;


    public function testCreateFund()
    {
        $data = [
            'fund' => 'Test Fund',
            'manager' => 'Test Manager',
            'year' => '2023',
            'aliases' => ['alias1', 'alias2'],
        ];

        $response = $this->postJson('/api/funds', $data);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);
    }

    public function testReadFund()
    {
        $this->seed(FundManagerSeeder::class);
        $this->seed(FundSeeder::class);


        $response = $this->get('/api/funds');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data',
        ]);

        $responseData = $response->json();
        $this->assertArrayHasKey('data', $responseData);
    }

    public function testUpdateFund()
    {
        $this->seed(FundManagerSeeder::class);
        $this->seed(FundSeeder::class);

        $fund = Fund::inRandomOrder()->first();

        // Use to update fund
        $newData = [
            'fund' => 'Updated Fund',
            'manager' => 'Manager Test 1',
            'year' => 2025,
            'aliases' => ['Alias4', 'Alias5'],
        ];

        $response = $this->put('/api/funds/' . $fund->id, $newData);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Fund has been updated successfully.',
                'data' => [
                    'name' => 'Updated Fund',
                    'start_year' => 2025,
                    'aliases' => ['Alias4', 'Alias5'],
                ],
            ]);
    }
}

