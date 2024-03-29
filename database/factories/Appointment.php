<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Appointment;
use Faker\Generator as Faker;
use Faker\Factory as Factory;

$factory->define(Appointment::class, function (Faker $faker) {
    return [
    	'doctor_id' => rand(1,25),
		'pacient_id' => rand(1,25),
		'date' => date('Y-m-d', rand(time(), strtotime('+2 months'))),
		'time' => date('H:m', rand(strtotime('06:00'), strtotime('17:59'))),
		'price' => rand(0,50000) / 100,
		'procedure' => $faker->word,
    ];
});
