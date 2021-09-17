<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEmployeeRequest extends FormRequest
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
            "phone" => "nullable|digits_between:10,12",
            "first_name" => "required|string",
            "last_name" => "required|string",
            "company" => "required|integer|exists:companies,id",
            "email" =>  [
                            'sometimes', 
                            'email',
                            Rule::unique('employees')->ignore($this->employee),
                            Rule::unique('users')->ignore($this->employee->user)
                        ],
        ];
    }

    public function messages()
    {
        return [
            'company.exists' => 'Invalid Company Passed.',
        ];
    }
}
