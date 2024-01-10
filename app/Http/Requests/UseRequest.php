<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UseRequest extends FormRequest
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
            'email' => 'required|unique:users,email',
            'role' => 'required',
            'password' => 'required|min: 6',
           
           
        ];
    }

    public function messages(): array
    {
        return [
            'firstname.required' => 'The firstname field is required',
            'lastname.required' => 'The lastname field is required',
            'email.required' => 'The email field is required',
            'email.min' => 'The email field must contain at least ',
            'email.unique' => 'The email ready exists ',
            'role.required' => 'The role field is required',
            'password.required' => 'The password field is required',
            'password.min' => 'The password  containt at least 6 elemens'
        ];
    }
}
