<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomRequest extends FormRequest
{  public function authorize(): bool
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
            'libelle' => 'required|min: 3',
            'montant' => 'required',
            'type' => 'required',
            'short' => 'required',
            'image' => 'required|image|mimes:jpeg,jpg,png,gif,svg|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'libelle.required' => 'The title field is required',
            'libelle.min' => 'The field must contain at least 3 characters',
            'type.required' => 'The type field is required',
            'short.required' => 'The short field is required',
            'montant.required' => 'The title field is required',
            'image.required' => 'The image field is required',
            'image.image' => 'Your file must be an image format Jpeg, jpg, gif, please',
            'image.required' => 'Your image should not exceed 2048 (2Mbt)'
        ];
    }
}
