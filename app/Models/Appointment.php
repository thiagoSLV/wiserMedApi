<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Appointment.
 *
 * @package namespace App\Models;
 */
class Appointment extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'appointments';
    
    protected $fillable = [
    	'doctor_id',
		'pacient_id',
		'date',
		'time',
        'price',
        'procedure',
    ];

    public $timestamps = true;

    public function doctor()
    {
        return $this->belongsTo(\App\Models\Doctor::class);
    }

    public function pacient()
    {
        return $this->belongsTo(\App\Models\Pacient::class);
    }

}
