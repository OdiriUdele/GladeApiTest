<?php

namespace Tests\Feature\Employee;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class EmployeeUpdateTest extends TestCase
{

    protected $companyId;
    protected $employeeId;

    public function testRequiredFieldsForUpdate()
    {
        $this->loginAdmin();

        $this->employeeId = $this->successfulEmployeeCreation()[1];

        $this->json('POST', 'api/employee/update/'.$this->employeeId)
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "first_name" => ["The first name field is required."],
                ]
            ]);
    }

    public function testExistingEmailValidation()
    {
        $this->loginAdmin();

        $success = $this->successfulEmployeeCreation();
        
        $this->employeeId = $success[1];
        $this->companyId = $success[0];

        $employeeData = [
            "first_name" => "testCompany",
            "last_name" => "testCompany",
            "email" => "firstadmin@admin.com",
            "company" => $this->companyId
        ];

       $this->json('POST', 'api/employee/update/'.$this->employeeId, $employeeData)
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "email" => ["The email has already been taken."]
                ]
            ]);
    }

    public function testSuccessfulEmployeeUpdate()
    {

        $this->loginAdmin();

        $success = $this->successfulEmployeeCreation();

        $this->employeeId = $success[1];
        $this->companyId = $success[0];

        $employeeData = [
            "first_name" => "test Company",
            "last_name" => "test Company",
            "company" => $this->companyId,
        ];

        $response = $this->json('POST', 'api/employee/update/'.$this->employeeId, $employeeData);
           
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                "data" => [
                    'id',
                    'first_name',
                ],
                "message"
            ])
            ->assertJson([
                'status' => true,
                "data" => [
                    "id" => $this->employeeId,
                    "first_name" => "test Company"
                ]
            ]);
    }
}
