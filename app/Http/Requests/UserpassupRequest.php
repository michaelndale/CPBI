<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserpassupRequest extends FormRequest
{ 

    public function authorize(): bool
    {
        return true;
    }


   public function rules(): array
   {
       return [
        'newpassword' => 'required|min: 4',
        'confirmpassword' => 'required|min: 4'  
       ];
   }

   public function messages(): array
   {
       return [
           'confirmpassword.required' => 'The Confirm password field is required',
           'confirmpassword.min' => 'The confirm password  containt at least 6 elemens',

           'olderpassword.required' => 'The password field is required',
           'olderpassword.min' => 'The password  containt at least 6 elemens',
       ];
   }
}
