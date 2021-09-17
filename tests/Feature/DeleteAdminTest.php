<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class DeleteAdminTest extends TestCase
{
    public function testInvalidUser()
    {
        $this->loginAdmin();

        $this->json('POST', 'api/admin/delete/10')
            ->assertStatus(404)
            ->assertJson([
                "message" => "Resource(s)/Route Not Found. (No query results for model [App\\User] 10)",
            ]);
    }

    public function testInvalidAdmin()
    {
        $this->loginAdmin();

        $this->json('POST', 'api/admin/delete/1')
            ->assertStatus(422)
            ->assertJson([
                "message" => "User is not an Admin.",
            ]);
    }

    public function testSuccessfulAdminDelete()
    {

        $this->loginAdmin();

        $admin = User::where('email', 'firstadmin@admin.com')->first('id');

        $response = $this->json('POST', 'api/admin/delete/'.$admin->id);
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                "status",
                "message"
            ])
            ->assertJson([
                'status' => true,
                "message" => "Admin User Deleted succesfully."
            ]);
    }
  
}
