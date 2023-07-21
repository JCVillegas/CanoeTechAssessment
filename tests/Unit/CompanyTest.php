<?php

namespace Tests\Unit;

use App\Models\Company;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    /** @test */
    public function can_create_a_company()
    {
        $companyName = [
            'name' => 'Test Company',
            // Add other attributes as needed
        ];

        $company = Company::create($companyName);

        $this->assertInstanceOf(Company::class, $company);
        $this->assertEquals('Test Company', $company->name);

    }


}
