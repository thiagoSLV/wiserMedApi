<?php

namespace App\Http\Requests;

use App\Models\Doctor;
use Illuminate\Foundation\Http\FormRequest;

class DoctorCreateRequest extends FormRequest
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
        $table = Doctor::make()->getTable();
        return [
                "cpf" => "numeric|digits:11|unique:{$table}",
                "cnpj" => "numeric|digits:14|unique:{$table}",
                "crm" => "required|numeric|unique:{$table}",
                "name" => "required|alpha",
                "lastName" => "required|alpha",
                "phoneNumber" => "required|numeric|unique:{$table}",
                "address" => "required|unique:{$table}",
                "email" => "required|unique:{$table}",
                "password" => "required",
        ];
    }
}
