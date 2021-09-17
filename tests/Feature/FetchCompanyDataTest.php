<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class FetchCompanyDataTest extends TestCase
{
    public function login($email=""){
        $user = User::where('email',$email)->first();

        $this->actingAs($user);
    }

    public function testUnauthorizedOperation()
    {
        $this->login('firstadmin@admin.com');

        $this->json('GET', 'api/company/info')
            ->assertStatus(403)
            ->assertJson([
                "message" => "Unauthorized User Operation.",
            ]);
    }

    public function testFetchEmployeesInfo()
    {
        $companyId = $this->successfulEmployeeCreation();

        $this->login('odiriudele@test.com');

        $response = $this->json('GET', 'api/company/info');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                "status",
                "data",
                "message"
            ])
            ->assertJson([
                "status" => true,
                "message" => "Company Records Fetched Successfully.",
                "data" => [
                    "id" => $companyId[0],
                    "name" => "test Company",
                    "email" => "test@testcompany.com",
                    "website" => null,
                    "logo" => null
                ]
            ]);
    }
}
