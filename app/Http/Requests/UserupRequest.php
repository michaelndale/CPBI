<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserupRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'firstname' => 'required|min: 3',
            'lastname' => 'required',
            'email' => 'required',
            'role' => 'required',
          
           
        ];
    }

    public function messages(): array
    {
        return [
            'firstname.required' => 'The firstname field is required',
            'lastname.required' => 'The lastname field is required',
            'email.required' => 'The email field is required',
            'email.min' => 'The email field must contain at least ',
            'role.required' => 'The role field is required',
        
        ];
    }
}
