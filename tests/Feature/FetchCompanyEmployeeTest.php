<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class FetchCompanyEmployeeTest extends TestCase
{
    public function login($email=""){
        $user = User::where('email',$email)->first();

        $this->actingAs($user);
    }

    public function testUnauthorizedOperation()
    {
        $this->login('firstadmin@admin.com');

        $this->json('GET', 'api/employee/all')
            ->assertStatus(403)
            ->assertJson([
                "message" => "Unauthorized User Operation.",
            ]);
    }

    public function testFetchEmployeesInfo()
    {
        $companyId = $this->successfulEmployeeCreation();

        $this->login('test@testcompany.com');

        $response = $this->json('GET', 'api/employee/all');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                "status",
                "data",
                "message"
            ])
            ->assertJson([
                "status" => true,
                "message" => "Company Employees Fetched succesfully.",
                "data" => [
                    [
                        "first_name" => "testOdiri",
                        "last_name" => "testUdele",
                        "company" => "test Company",
                    ]
                ]
            ]);
    }
}
