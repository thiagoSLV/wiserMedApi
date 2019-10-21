<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Doctor;
use Faker\Generator as Faker;
use Faker\Factory as Factory;


$factory->define(Doctor::class, function (Faker $faker) {
    
	$faker = Factory::create('pt_BR');
    $fisico = rand(0,1); //randomico para criar com cpf ou cnpj
    
    return [
		'cpf' => $fisico ? $faker->cpf(false) : NULL,
		'cnpj' => !$fisico ? $faker->cnpj(false) : NULL,
		'name' => $faker->firstName() ,
		'specialty' => $faker->word ,
		'lastName' => $faker->lastname() ,
		'address' => $faker->address() ,
		'crm' => rand(0,999) ,
		'phoneNumber' => rand(10000000, 99999999),
		'email' => $faker->email() ,
		'password' => Hash::make(rand(0,999)) ,
    ];
});
