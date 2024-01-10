<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SlideupRequest extends FormRequest
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
            'titre' => 'required|min: 3',
            'description' => 'required',
            'short' => 'required',
            'tag' => 'required',
           
        ];
    }

    public function messages(): array
    {
        return [
            'titre.required' => 'The title field is required',
            'titre.min' => 'The field must contain at least 3 characters',
            'description.required' => 'The description field is required',
            'short.required' => 'The short field is required',
           
            'tag.required' => 'The title field is required',
           
        ];
    }
}
