<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;

class RegisterException extends Exception
{
    public function report()
    {

    }

    public function render($request)
    {
    	$this->message = "CPF or CNPJ must be given";
    	return response()->json([
    		'message' => $this->message,
    		'code' => $this->code,
    	], $this->code);
    }
}
