<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GeneralRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'namesite' => 'required',
            'adress' => 'required',
            'email' => 'required',
            'description' => 'required'
            
        ];
    }

    public function messages(): array
    {
        return [
            'namesite.required' => 'The namesite field is required',
            'adress.required' => 'The adresse field is required',
            'email.required' => 'The email field is required',
            'description.required' => 'The description field is required'
        ];
    }
}
