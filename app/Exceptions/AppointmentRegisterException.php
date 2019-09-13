<?php

namespace App\Exceptions;

use Exception;

class AppointmentRegisterException extends Exception
{
	protected $message = "Appointment already registered to given date and time";
	protected $code = 400;
}
