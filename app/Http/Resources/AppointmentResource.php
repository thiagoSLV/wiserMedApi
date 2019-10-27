<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'doctor_id' => $this->doctor_id,
            'doctor_name' => $this->doctor->name,
            'doctor_lastName' => $this->doctor->lastName,
            'pacient_id' => $this->pacient_id,
            'pacient_name' => $this->pacient->name,
            'pacient_lastName' => $this->pacient->lastName,
            'procedure' => $this->procedure,
            'date' => $this->date,
            'init' => $this->init,
            'finish' => $this->finish,
            'price' => $this->price,
        ];

    }
}
