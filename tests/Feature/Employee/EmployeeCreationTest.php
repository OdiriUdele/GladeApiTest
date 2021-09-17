<?php

namespace Tests\Feature\Employee;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class EmployeeCreationTest extends TestCase
{
    protected $companyId;

    public function loginAdmin(){
        $user = User::where('email','superadmin@admin.com')->first();

        $this->actingAs($user);
    }

    public function testRequiredFieldsForCreation()
    {
        $this->loginAdmin();

        $this->json('POST', 'api/employee/create')
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "first_name" => ["The first name field is required."],
                    "last_name" => ["The last name field is required."],
                    "company" => ["The company field is required."],
                ]
            ]);
    }

    public function testInvalidCompany()
    {
        $this->loginAdmin();

        $employeeData = [
            "first_name" => "testOdiri",
            "last_name" => "testUdele",
            "company" => 15
        ];

       $this->json('POST', 'api/employee/create', $employeeData)
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "company" => ["Invalid Company Passed."]
                ]
            ]);
    }

    public function testSuccessfulEmployeeCreation()
    {
        $this->loginAdmin();
        $this->companyId = $this->successfulCompanyCreation();

        $employeeData = [
            "first_name" => "testOdiri",
            "last_name" => "testUdele",
            "company" => $this->companyId
        ];

        $response = $this->json('POST', 'api/employee/create', $employeeData);
           
        $response
            ->assertStatus(201)
            ->assertJsonStructure([
                "data" => [
                    'id',
                    'first_name',
                    'last_name',
                ],
                "message"
            ])
            ->assertJson([
                'status' => true,
                'message' => 'Employee Created Successfully',
                "data" => [
                    "first_name" => "testOdiri",
                    "last_name" => "testUdele"
                ]
            ]);
    }
}
