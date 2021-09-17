<?php

namespace Tests\Feature;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{

    public function testRequiresEmailAndLogin()
    {
        $response = $this->json('POST', 'api/login');
            
        $response
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                'errors'=>[
                    'email' => ['The email field is required.'],
                    'password' => ['The password field is required.'],
                ]
            ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testLoginWithSuperAdminDetails()
    {
        $response = $this->json('post', '/api/login', [
            'email' => 'superadmin@admin.com',
            'password' =>'password'
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                "token",
                "token_type",
                "token_expires_in"
            ])
            ->assertJson([
                'status' => true,
                'message' => "Login Successful",
                "user" => [
                    "email" => "superadmin@admin.com"
                ]
            ]);
        
    }
}
