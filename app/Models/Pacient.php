<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
    use Illuminate\Notifications\Notifiable;
    use Illuminate\Foundation\Auth\User as Authenticatable;
/**
 * Class Pacient.
 *
 * @package namespace App\Models;
 */
class Pacient extends Authenticatable implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $table = 'pacients';

    protected $guard = 'pacient'; 

    protected $fields = [
        'id',
    	'cpf',
		'name',
		'lastName',
		'phoneNumber',
		'email',
		'password',
    ];

    protected $fillable = [
        'cpf',
        'name',
        'lastName',
        'phoneNumber',
        'email',
        'password',
    ];

    public $timestamps = true;

    public function getTable(){
        return $this->table;
    }
}
