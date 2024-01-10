<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'titre' => 'required|min: 3|unique:profiles,title'
           
        ];
    }

    public function messages(): array
    {
        return [
            'titre.required' => 'The title field is required',
            'titre.min' => 'The field must contain at least 3 characters',
            'titre.unique' => 'The title already exists'
        ];
    }
}
