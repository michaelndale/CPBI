<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            'name' => 'required|min: 3',
            'email' => 'required|email',
            'phone' => 'required',
            'competence' => 'required'
       
        ];
    }

    public function competences(): array
    {
        return [
            'name.required' => 'The name field is required',
            'name.min' => 'The field must contain at least 3 characters',
            'email.required' => 'The email field is required',
            'email.min' => 'The field must contain email',
            'phone.required' => 'The phone field is required',
            'competence.required' => 'The competence field is required'
        ];
    }
}
