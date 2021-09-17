<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class AuditRequest extends FormRequest
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
            'date_from'  => 'sometimes|date',
            'date_to'   => 'sometimes|date',
            'admin_email' => 'sometimes|email',
            'admin_id' => 'sometimes|integer',
            'company' => 'sometimes|string'
        ];
    }
}
