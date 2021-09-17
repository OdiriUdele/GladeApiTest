<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class CreateCompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "email" => "sometimes|email|unique:companies|unique:users",
            "name" => "required|string|unique:companies",
            "website" => "nullable|string",
            "logo" => "bail|nullable|file|dimensions:width=100,height=100|mimes:jpeg,jpg,png,jfif"
        ];
    }

    public function messages()
    {
        return [
            'logo.mimes' => 'logo must be a file',
            'logo.dimensions' => 'logo dimension must be between 100 x 100',
        ];
    }
}
