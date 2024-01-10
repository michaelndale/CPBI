<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SlideRequest extends FormRequest
{
      /**
     * Determine if the user is authorized to make this request.
     */
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
            'image' => 'required|image|mimes:jpeg,jpg,png,gif,svg|max:2048',
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
            'image.required' => 'The image field is required',
            'image.image' => 'Your file must be an image format Jpeg, jpg, gif, please',
            'image.required' => 'Your image should not exceed 2048 (2Mbt)'
        ];
    }
}
