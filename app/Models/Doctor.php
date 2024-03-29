<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
/**
 * Class Doctor.
 *
 * @package namespace App\Models;
 */
class Doctor extends Authenticatable implements Transformable 
{
    use TransformableTrait;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $table = 'doctors';

    protected $guard = 'doctor'; 

    protected $fillable = [
        'cpf',
        'cnpj',
        'name',
        'lastName',
        'specialty',
        'address',
        'crm',
        'phoneNumber',
        'email',
        'password',

    ];

    protected $hidden = [
        'password',
        'rememberToken', 
    ];

    public $timestamps = true;

}
