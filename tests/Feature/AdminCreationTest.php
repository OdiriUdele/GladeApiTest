<?php

namespace Tests\Feature;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class AdminCreationTest extends TestCase
{
    public function loginSuperAdmin(){
        $user = User::where('email','superadmin@admin.com')->first();

        $this->actingAs($user);
    }

    public function testRequiredFieldsForRegistration()
    {
        $this->loginSuperAdmin();

        $this->json('POST', 'api/admin/create')
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "email" => ["The email field is required."],
                    "password" => ["The password field is required."],
                ]
            ]);
    }

    public function testRepeatPassword()
    {
        $this->loginSuperAdmin();

        $userData = [
            "email" => "doe@example.com",
            "password" => "demo12345"
        ];

       $this->json('POST', 'api/admin/create', $userData)
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "password" => ["The password confirmation does not match."]
                ]
            ]);
    }

    public function testSuccessfulRegistration()
    {
        $this->loginSuperAdmin();

        $userData = [
            "email" => "doe@example.com",
            "password" => "demo12345",
            "password_confirmation" => "demo12345"
        ];

        $this->json('POST', 'api/admin/create', $userData, ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertJsonStructure([
                "data" => [
                    'id',
                    'email',
                ],
                "message"
            ])
            ->assertJson([
                'status' => true,
                "data" => [
                    "email" => "doe@example.com"
                ]
            ]);
    }


}
