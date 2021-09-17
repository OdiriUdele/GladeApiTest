<?php

namespace Tests\Feature\Company;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class CompanyDeleteTest extends TestCase
{
    protected $companyId;

    public function testInvalidCompany()
    {
        $this->loginAdmin();

        $this->json('POST', 'api/company/delete/10')
            ->assertStatus(404)
            ->assertJson([
                "message" => "Resource(s)/Route Not Found. (No query results for model [App\\Company] 10)",
            ]);
    }


    public function testSuccessfulCompanyDelete()
    {

        $this->loginAdmin();

        $this->companyId = $this->successfulCompanyCreation();

        $response = $this->json('POST', 'api/company/delete/'.$this->companyId);
           
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                "status",
                "message"
            ])
            ->assertJson([
                'status' => true,
                "message" => "Company Deleted succesfully."
            ]);
    }

}
