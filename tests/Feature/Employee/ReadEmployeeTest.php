<?php

namespace Tests\Feature\Company;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class ReadEmployeeTest extends TestCase
{
    protected $employeeId;

    public function testInvalidCompany()
    {
        $this->loginAdmin();

        $this->json('GET', 'api/employee/fetch/10')
            ->assertStatus(404)
            ->assertJson([
                "message" => "Resource(s)/Route Not Found. (No query results for model [App\\Employee] 10)",
            ]);
    }


    public function testSuccessfulReadEmployee()
    {

        $this->loginAdmin();

        $success = $this->successfulEmployeeCreation();

        $this->employeeId = $success[1];

        $response = $this->json('GET', 'api/employee/fetch/'.$this->employeeId);
           
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                "status",
                "message"
            ])
            ->assertJson([
                'status' => true,
                "message" => "Employee Records Fetched Successfully."
            ]);
    }
}
