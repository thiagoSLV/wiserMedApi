<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;

class RegisterException extends Exception
{
    protected $message = "CPF or CNPJ must be given";
    protected $code = 400;

    public function report()
    {

    }

    public function render($request)
    {
    	return response()->json([
    		'message' => $this->getMessage(),
    		'code' => $this->code,
    	], $this->code);
    }
}
