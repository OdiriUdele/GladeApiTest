<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class AdminOperationsTest extends TestCase
{

    public function login($email){
        $user = User::where('email',$email)->first();

        $this->actingAs($user);
    }

    public function testUnauthorizedOperation()
    {
        $this->login('uniqueadmin@admin.com');

        $this->json('GET', 'api/ops/fetch-employees')
            ->assertStatus(403)
            ->assertJson([
                "message" => "Unauthorized User Operation.",
            ]);
    }

    public function testFetchCompanies(){

        $this->loginAdmin();

        $success = $this->successfulCompanyCreation();

        $admin = User::where('email', 'firstadmin@admin.com')->first('id');

        $response = $this->json('GET', 'api/ops/fetch-companies');
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                "status",
                "message",
                "data",
                "links"
            ])
            ->assertJson([
                'status' => true,
                "message" => "Companies Fetched succesfully."
            ]);
    }

    public function testFetchEmployees(){
        $this->loginAdmin();

        $admin = User::where('email', 'firstadmin@admin.com')->first('id');

        $success = $this->successfulEmployeeCreation();

        $response = $this->json('GET', 'api/ops/fetch-employees');
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                "status",
                "message",
                "data",
                "links"
            ])
            ->assertJson([
                'status' => true,
                "message" => "All Employees Fetched succesfully."
            ]);
    }

    public function testFetchCompanyEmployees(){
        $this->loginAdmin();

        $admin = User::where('email', 'firstadmin@admin.com')->first('id');

        $success = $this->successfulEmployeeCreation();

        $response = $this->json('GET', 'api/ops/'.$success[0].'/fetch-employees');
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                "status",
                "message",
                "data",
                "links",
            ])
            ->assertJson([
                'status' => true,
                "message" => "Company Employees Fetched succesfully."
            ]);
    }
}
