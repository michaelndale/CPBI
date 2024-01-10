<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RervationoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array <string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|min: 3',
            'email' => 'required',
            'datearrive' => 'required',
            'datedepart' => 'required',
            'nombreadulte' => 'required',
            'chambrereference' => 'required',
            'quanatite' => 'required',
            'phone' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Le nom est obligatoire',
            'name.min' => 'Le nom dois avoir au mimum 3 caracter',
            'email.required' => 'Email est obligatoire',
            'datearrive.required' => 'Date de d\'arrive ',
            'datedepart.required' => 'Date de depart est obligatoire',
            'nombreadulte.required' => 'Le nombre des adultes est obligatoire',
            'chambrereference.required' => 'Le chambre est obligatoire ',
            'quanatite.required' => 'Quantité est obligatoire ',
            'phone' => 'Numero est obligatoire'
        ];
    }
}
