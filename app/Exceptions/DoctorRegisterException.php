<?php

namespace App\Exceptions;

use Exception;

class DoctorRegisterException extends Exception
{
    protected $message = "CPF or CNPJ must be given";
    protected $code = 400;
}


