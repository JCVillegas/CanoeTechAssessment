<?php

namespace Tests\Unit\Database;

use App\Http\Controllers\Requests\FundPostRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class FundPostRequestTest extends TestCase
{
    /** @test */
    public function it_validates_fund_post_request()
    {

        $payload = [
            'fund'    => 'Test Fund',
            'manager' => 'Test Manager',
            'year'    => 2023,
        ];

        $validator = Validator::make($payload, (new FundPostRequest())->rules());

        $this->assertTrue($validator->passes());


        $missingPayload = [
            'year' => 'Invalid Year',
        ];

        try {
            $validator = Validator::make($missingPayload, (new FundPostRequest())->rules());
            $validator->passes();
        } catch (ValidationException $e) {
            $this->assertEquals('The given data was invalid.', $e->getMessage());
            $errors = $e->errors();
            $this->assertArrayHasKey('fund', $errors);
            $this->assertArrayHasKey('manager', $errors);
            $this->assertArrayHasKey('year', $errors);
        }
    }
}
