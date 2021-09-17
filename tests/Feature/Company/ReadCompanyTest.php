<?php

namespace Tests\Feature\Company;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class ReadCompanyTest extends TestCase
{
    protected $companyId;

    public function testInvalidCompany()
    {
        $this->loginAdmin();

        $this->json('GET', 'api/company/fetch/10')
            ->assertStatus(404)
            ->assertJson([
                "message" => "Resource(s)/Route Not Found. (No query results for model [App\\Company] 10)",
            ]);
    }


    public function testSuccessfulReadCompany()
    {

        $this->loginAdmin();

        $this->companyId = $this->successfulCompanyCreation();

        $response = $this->json('GET', 'api/company/fetch/'.$this->companyId);
           
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                "status",
                "message"
            ])
            ->assertJson([
                'status' => true,
                "message" => "Company Records Fetched Successfully."
            ]);
    }
}
