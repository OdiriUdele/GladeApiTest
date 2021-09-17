<?php

namespace Tests\Feature\Company;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\User;

class CompanyUpdateTest extends TestCase
{

    protected $companyId;

    public function testRequiredFieldsForUpdate()
    {
        $this->loginAdmin();

        $this->companyId = $this->successfulCompanyCreation();

        $this->json('POST', 'api/company/update/'.$this->companyId)
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "name" => ["The name field is required."],
                ]
            ]);
    }

    public function testExistingEmailValidation()
    {
        $this->loginAdmin();

        $this->companyId = $this->successfulCompanyCreation();

        $companyData = [
            "name" => "test Company",
            "email" => "firstadmin@admin.com"
        ];

       $this->json('POST', 'api/company/update/'.$this->companyId, $companyData)
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "email" => ["The email has already been taken."]
                ]
            ]);
    }

    public function testSuccessfulCompanyUpdate()
    {

        Storage::fake('public');

        $this->loginAdmin();

        $this->companyId = $this->successfulCompanyCreation();

        $companyData = [
            "name" => "test Company",
            "logo" => UploadedFile::fake()->image('avatar.jpg', 100, 100)->size(400)
        ];

        $response = $this->json('POST', 'api/company/update/'.$this->companyId, $companyData);
           
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                "data" => [
                    'id',
                    'name',
                ],
                "message"
            ])
            ->assertJson([
                'status' => true,
                "data" => [
                    "id" => $this->companyId,
                    "name" => "test Company"
                ]
            ]);
            Storage::disk('public')->assertExists($response['data']['logo']);
            Storage::fake('public');
    }
}
