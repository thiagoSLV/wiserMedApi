<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Pacient;
use Faker\Generator as Faker;
use Faker\Factory as Factory;


$factory->define(Pacient::class, function (Faker $faker) {
	$faker = Factory::create('pt_BR');

    return [
    	'cpf' => $faker->cpf(false),
		'name' => $faker->firstName(),
		'lastName' => $faker->lastName(),
		'phoneNumber' => rand(10000000, 99999999),
		'email' => $faker->email(),
		'password' => rand(0,9999),
    ];
});
