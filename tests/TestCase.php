<?php

namespace Tests;


use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use JWTAuth;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /**
     * Set the currently logged in user for the application.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable $user
     * @param  string|null                                $driver
     * @return $this
     */
    public function actingAs($user, $driver = null)
    {
        $token = JWTAuth::fromUser($user);
        $this->withHeader('Authorization', "Bearer {$token}");
        parent::actingAs($user);
        
        return $this;
    }

    public function loginAdmin(){
        $user = User::where('email','superadmin@admin.com')->first();

        $this->actingAs($user);
    }

    public function successfulCompanyCreation()
    {

        $this->loginAdmin();

        $companyData = [
            "name" => "test Company",
        ];

        $response = $this->json('POST', 'api/company/create', $companyData);
          
        return $response['data']['id'];
    }

    public function successfulEmployeeCreation()
    {
        $this->loginAdmin();

        $companyId =  $this->successfulCompanyCreation();

        $employeeData = [
            "first_name" => "testOdiri",
            "last_name" => "testUdele",
            "company" => $companyId
        ];

        $response = $this->json('POST', 'api/employee/create', $employeeData);
           
        return [$companyId, $response['data']['id']];
    }
}
