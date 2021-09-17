<?php

namespace Tests\Feature\Company;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\User;

class CompanyCreationTest extends TestCase
{

    public function testRequiredFieldsForUpdate()
    {
        $this->loginAdmin();

        $this->json('POST', 'api/company/create')
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "name" => ["The name field is required."],
                ]
            ]);
    }

    public function testInvalidFileSize()
    {
        $this->loginAdmin();

        $companyData = [
            "name" => "test Company",
            "logo" => UploadedFile::fake()->image('avatar.jpg', 400, 400)->size(400)
        ];

       $this->json('POST', 'api/company/create', $companyData)
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "logo" => ["logo dimension must be between 100 x 100"]
                ]
            ]);
    }

    public function testSuccessfulCompanyCreation()
    {

        Storage::fake('public');

        $this->loginAdmin();

        $companyData = [
            "name" => "test Company",
            "logo" => UploadedFile::fake()->image('avatar.jpg', 100, 100)->size(400)
        ];

        $response = $this->json('POST', 'api/company/create', $companyData);
           
        $response
            ->assertStatus(201)
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
                    "name" => "test Company"
                ]
            ]);
            Storage::disk('public')->assertExists($response['data']['logo']);
            Storage::fake('public');
    }
}
