<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Doctor;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Faker\Factory;

class DoctorTest extends TestCase
{
    //refresh database for tests
    public function setUp(): void
    {
        parent::setUp();
        \Artisan::call('migrate:refresh');
        \Artisan::call('db:seed');
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetAll()
    {
        $response = $this->call('GET', route('doctor.all'));

        $response->assertStatus(200);
    }

    public function testGetByEspecialty()
    {
        $route = 'doctor.specialty';

        //Feeding table for "LIKE Search"
        //------------------------------------------------------------------------
        factory(Doctor::class)->create([
            'specialty' => 'Teste',
        ]);

        factory(Doctor::class)->create([
            'specialty' => 'Tes',
        ]);

        factory(Doctor::class)->create([
            'specialty' => 'Teste extend.',
        ]);

        factory(Doctor::class)->create([
            'specialty' => 'este',
        ]);

        $response = $this->call('GET', route($route, ['T']));

        //Success request
        //------------------------------------------------------------------------
        $response
            ->assertStatus(200)
            ->assertJsonFragment(['specialty' => 'Teste'])
            ->assertJsonFragment(['specialty' => 'Tes'])
            ->assertJsonFragment(['specialty' => 'Teste extend.'])
            ->assertJsonMissing(['specialty' => 'este']);
    }

    public function testGetById()
    {
        $route = 'doctor';
        $doctor = factory(Doctor::class)->create();

        $response = $this->call('GET', route($route, ['id'=> $doctor->id]));

        //Success request
        //------------------------------------------------------------------------
        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'name' => $doctor->name,
                'crm' => $doctor->crm,
                'lastName' => $doctor->lastName,
                'phoneNumber' => $doctor->phoneNumber,
                'email' => $doctor->email,
                'address' => $doctor->address,
            ]);

        //Wrong id format
        //------------------------------------------------------------------------
        $response = $this->call('GET', route($route, 'string'));

        $response
            ->dump()
            ->assertStatus(400);
    }

    public function testCreate()
    {

        $doctor = factory(doctor::class)->make();
        $faker = Factory::create('pt_BR');

        $route = 'doctor.store';

        //Testing request without fields, bad request
        //--------------------------------------------------------
        $response = $this->call('POST', route($route, [
            'name' => $doctor->name,
            'crm' => $doctor->crm,
            'lastName' => $doctor->lastName,
            'specialty' => $doctor->specialty,
            'phoneNumber' => $doctor->phoneNumber,
            'email' => $doctor->email,
            'address' => $doctor->address,
            'password' => $doctor->password,
        ]));

        $response
            ->dump()
            ->assertStatus(400);

        $response = $this->call('POST', route($route, [
            'cpf' => $faker->cpf(false),
            'crm' => $doctor->crm,
            'lastName' => $doctor->lastName,
            'specialty' => $doctor->specialty,
            'phoneNumber' => $doctor->phoneNumber,
            'email' => $doctor->email,
            'address' => $doctor->address,
            'password' => $doctor->password,
        ]));

        $response
            ->dump()
            ->assertStatus(422);  

        $response = $this->call('POST', route($route, [
            'name' => $doctor->name,
            'cpf' => $faker->cpf(false),
            'lastName' => $doctor->lastName,
            'specialty' => $doctor->specialty,
            'phoneNumber' => $doctor->phoneNumber,
            'email' => $doctor->email,
            'address' => $doctor->address,
            'password' => $doctor->password,
        ]));

        $response
            ->dump()
            ->assertStatus(422);

        $response = $this->call('POST', route($route, [
            'name' => $doctor->name,
            'specialty' => $doctor->specialty,
            'cnpj' => $faker->cnpj(false),
            'crm' => $doctor->crm,
            'email' => $doctor->email,
            'address' => $doctor->address,
            'password' => $doctor->password,
        ]));

        $response
            ->dump()
            ->assertStatus(422);  

        $response = $this->call('POST', route($route, [
            'name' => $doctor->name,
            'cnpj' => $faker->cnpj(false),
            'crm' => $doctor->crm,
            'lastName' => $doctor->lastName,
            'specialty' => $doctor->specialty,
            'phoneNumber' => $doctor->phoneNumber,
            'address' => $doctor->address,
            'password' => $doctor->password,
        ]));

        $response
            ->dump()
            ->assertStatus(422);  

        $response = $this->call('POST', route($route, [
            'name' => $doctor->name,
            'cnpj' => $faker->cnpj(false),
            'crm' => $doctor->crm,
            'lastName' => $doctor->lastName,
            'specialty' => $doctor->specialty,
            'phoneNumber' => $doctor->phoneNumber,
            'email' => $doctor->email,
            'password' => $doctor->password,
        ]));

        $response
            ->dump()
            ->assertStatus(422);

        $response = $this->call('POST', route($route, [
            'name' => $doctor->name,
            'cnpj' => $faker->cnpj(false),
            'crm' => $doctor->crm,
            'lastName' => $doctor->lastName,
            'specialty' => $doctor->specialty,
            'phoneNumber' => $doctor->phoneNumber,
            'email' => $doctor->email,
        ]));

        $response
            ->dump()
            ->assertStatus(422);  

        $response = $this->call('POST', route($route, [
            'name' => $doctor->name,
            'cnpj' => $faker->cnpj(false),
            'crm' => $doctor->crm,
            'specialty' => $doctor->specialty,
            'phoneNumber' => $doctor->phoneNumber,
            'email' => $doctor->email,
            'password' => $doctor->password,
        ]));

        $response
            ->dump()
            ->assertStatus(422);  

        //--------------------------------------------------------

        //Test wrong data on fields
         $response = $this->call('POST', route($route, [
            'cpf' => $faker->word,
            'name' => $doctor->name,
            'lastName' => $doctor->lastName,
            'specialty' => $doctor->specialty,
            'phoneNumber' => $doctor->phoneNumber,
            'email' => $doctor->email,
            'password' => $doctor->password,
        ]));

        $response
            ->dump()
            ->assertStatus(422);

        $response = $this->call('POST', route($route, [
            'cpf' => rand(0,100),
            'name' => $doctor->name,
            'lastName' => $doctor->lastName,
            'specialty' => $doctor->specialty,
            'phoneNumber' => $doctor->phoneNumber,
            'email' => $doctor->email,
        ]));

        $response
            ->dump()
            ->assertStatus(422);

        $response = $this->call('POST', route($route, [
            'cpf' => rand(100000000000, 999999999999),
            'name' => $doctor->name,
            'lastName' => $doctor->lastName,
            'specialty' => $doctor->specialty,
            'phoneNumber' => $doctor->phoneNumber,
            'email' => $doctor->email,
        ]));

        $response
            ->dump()
            ->assertStatus(422);

        $response = $this->call('POST', route($route, [
            'cpf' => $doctor->cpf,
            'name' => rand(0,100),
            'lastName' => $doctor->lastName,
            'specialty' => $doctor->specialty,
            'phoneNumber' => $doctor->phoneNumber,
            'email' => $doctor->email,
        ]));

        $response
            ->dump()
            ->assertStatus(422);

        $response = $this->call('POST', route($route, [
            'cpf' => $doctor->cpf,
            'name' => $doctor->lastName,
            'lastName' => rand(0,100),
            'specialty' => $doctor->specialty,
            'phoneNumber' => $doctor->phoneNumber,
            'email' => $doctor->email,
        ]));

        $response
            ->dump()
            ->assertStatus(422);

        $response = $this->call('POST', route($route, [
            'cpf' => $doctor->cpf,
            'name' => $doctor->lastName,
            'lastName' => $doctor->lastName,
            'specialty' => rand(0,100),
            'phoneNumber' => $doctor->phoneNumber,
            'email' => $doctor->email,
        ]));

        $response
            ->dump()
            ->assertStatus(422);

        //--------------------------------------------------------

        //Success request
        $response = $this->call('POST', route($route, $doctor->toArray()));

        $id = json_decode($response->getContent())->data->id;
        $doctor = array_filter(Doctor::find($id)->toArray());

        $response
            ->dump()
            ->assertStatus(200)
            ->assertJson([
                'message' => 'Doctor created.',
                'data' => $doctor,
            ]);  
        //--------------------------------------------------------

        //Duplicated unique fields
        $response = $this->call('POST', route($route, $doctor));

        $response
            ->dump()
            ->assertStatus(422);

    }
}
