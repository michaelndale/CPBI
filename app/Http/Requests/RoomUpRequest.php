<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomUpRequest extends FormRequest
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
            'libelle' => 'required|min: 3',
            'montant' => 'required',
            'type' => 'required',
            'short' => 'required',
        
        ];
    }

    public function messages(): array
    {
        return [
            'libelle.required' => 'The title field is required',
            'libelle.min' => 'The field must contain at least 3 characters',
            'type.required' => 'The type field is required',
            'short.required' => 'The short field is required',
            'montant.required' => 'The title field is required'
        ];
    }
}
