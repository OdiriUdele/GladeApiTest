<?php

namespace Tests\Feature\Company;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class EmployeeDeleteTest extends TestCase
{
    protected $employeeId;

    public function testInvalidEmployee()
    {
        $this->loginAdmin();

        $this->json('POST', 'api/employee/delete/10')
            ->assertStatus(404)
            ->assertJson([
                "message" => "Resource(s)/Route Not Found. (No query results for model [App\\Employee] 10)",
            ]);
    }


    public function testSuccessfulEmployeeDelete()
    {

        $this->loginAdmin();

        $success = $this->successfulEmployeeCreation();

        $this->employeeId = $success[1];

        $response = $this->json('POST', 'api/employee/delete/'.$this->employeeId);
           
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                "status",
                "message"
            ])
            ->assertJson([
                'status' => true,
                "message" => "Employee Deleted succesfully."
            ]);
    }

}
