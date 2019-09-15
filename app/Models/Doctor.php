<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Doctor.
 *
 * @package namespace App\Models;
 */
class Doctor extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $table = 'doctors';

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

    public $timestamps = true;

}
