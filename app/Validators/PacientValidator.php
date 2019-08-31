<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class PacientValidator.
 *
 * @package namespace App\Validators;
 */
class PacientValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
        	'cpf' => 'required|max:11',
			'name' => 'required',
			'lastName' => 'required',
			'phoneNumber' => 'required',
			'email' => 'required',
			'password' => 'required',
        ],
        ValidatorInterface::RULE_UPDATE => [],
    ];
}
