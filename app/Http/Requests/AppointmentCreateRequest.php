<?php

namespace App\Http\Requests;

use App\Models\Appointment;
use Illuminate\Foundation\Http\FormRequest;

class AppointmentCreateRequest extends FormRequest
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
        $table = Appointment::make()->getTable();
        return [
            'doctor_id' => "required|numeric",
            'pacient_id' => "required|numeric",
            'date' => "required|date_format:Y-m-d",
            'time' => "required|date_format:H:i",
            'price' => "required|numeric",
            'procedure' => "required|alpha",
        ];
    }
}
