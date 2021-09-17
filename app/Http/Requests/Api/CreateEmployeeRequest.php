<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class CreateEmployeeRequest extends FormRequest
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
            "email" => "sometimes|email|unique:employees|unique:users",
            "phone" => "nullable|digits_between:10,12",
            "first_name" => "required|string",
            "last_name" => "required|string",
            "company" => "required|integer|exists:companies,id",
        ];
    }

    public function messages()
    {
        return [
            'company.exists' => 'Invalid Company Passed.',
        ];
    }
}
