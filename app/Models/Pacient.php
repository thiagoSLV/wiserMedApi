<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Pacient.
 *
 * @package namespace App\Models;
 */
class Pacient extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $table = 'pacients';

    protected $fillable = [
    	'cpf',
		'name',
		'lastName',
		'phoneNumber',
		'email',
		'password',
    ];

    public $timestamps = true;

}
