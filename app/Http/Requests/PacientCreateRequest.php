<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PacientCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // 'cpf' => 'required',
            // 'name' => 'required',
            // 'lastName' => 'required',
            // 'phoneNumber' => 'required',
            // 'email' => 'required',
            // 'password' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'cpf.required' => 'cpf é um campo obrigatório',
            'name.required' => 'name é um campo obrigatório',
            'lastName.required' => 'lastName é um campo obrigatório',
            'phoneNumber.required' => 'phoneNumber é um campo obrigatório',
            'email.required' => 'email é um campo obrigatório',
            'password.required' => 'password é um campo obrigatório',
        ];
    }
}
