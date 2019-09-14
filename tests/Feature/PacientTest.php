<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Pacient;
use Illuminate\Support\Facades\Validator;
use Faker\Factory;

class PacientTest extends TestCase
{    

    //refresh database for tests
    public function setUp(): void
    {
        parent::setUp();
        \Artisan::call('migrate:refresh');
        \Artisan::call('db:seed');
    }
    public function testGetAll()
    {
        $response = $this->call('GET', route('pacient.all'));

        $response->assertStatus(200);
    }

    public function testGetById()
    {
        $route = 'pacient';
        $pacient = factory(Pacient::class)->create();

        $response = $this->call('GET', route($route, ['id'=> $pacient->id]));

        //Success request
        //------------------------------------------------------------------------
        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'name' => $pacient->name,
                'lastName' => $pacient->lastName,
                'cpf' => (int)$pacient->cpf,
                'phoneNumber' => $pacient->phoneNumber,
                'email' => $pacient->email,
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

        $pacient = factory(Pacient::class)->make();
        $faker = Factory::create('pt_BR');

        //Testing request without fields, bad request
        //--------------------------------------------------------
        $response = $this->call('POST', route('pacient.store', [
            'name' => $pacient->name,
            'lastName' => $pacient->lastName,
            'phoneNumber' => $pacient->phoneNumber,
            'email' => $pacient->email,
            'password' => $pacient->password,
        ]));

        $response
            ->assertStatus(422)
            ->assertJsonFragment(['cpf' => ['The cpf field is required.']]);

        $response = $this->call('POST', route('pacient.store', [
            'cpf' => $pacient->cpf,
            'lastName' => $pacient->lastName,
            'phoneNumber' => $pacient->phoneNumber,
            'email' => $pacient->email,
            'password' => $pacient->password,
        ]));

        $response
            ->assertStatus(422)
            ->assertJsonFragment(['name' => ['The name field is required.']]);  

        $response = $this->call('POST', route('pacient.store', [
            'cpf' => $pacient->cpf,
            'name' => $pacient->name,
            'phoneNumber' => $pacient->phoneNumber,
            'email' => $pacient->email,
            'password' => $pacient->password,
        ]));

        $response
            ->assertStatus(422)
            ->assertJsonFragment(['lastName' => ['The last name field is required.']]);  

        $response = $this->call('POST', route('pacient.store', [
            'cpf' => $pacient->cpf,
            'name' => $pacient->name,
            'lastName' => $pacient->lastName,
            'email' => $pacient->email,
            'password' => $pacient->password,
        ]));

        $response
            ->assertStatus(422)
            ->assertJsonFragment(['phoneNumber' => ['The phone number field is required.']]);  

        $response = $this->call('POST', route('pacient.store', [
            'cpf' => $pacient->cpf,
            'name' => $pacient->name,
            'lastName' => $pacient->lastName,
            'phoneNumber' => $pacient->phoneNumber,
            'password' => $pacient->password,
        ]));

        $response
            ->assertStatus(422)
            ->assertJsonFragment(['email' => ['The email field is required.']]);  

        $response = $this->call('POST', route('pacient.store', [
            'cpf' => $pacient->cpf,
            'name' => $pacient->name,
            'lastName' => $pacient->lastName,
            'phoneNumber' => $pacient->phoneNumber,
            'email' => $pacient->email,
        ]));

        $response
            ->assertStatus(422)
            ->assertJsonFragment(['password' => ['The password field is required.']]);  

        //--------------------------------------------------------

        //Test wrong data on fields
         $response = $this->call('POST', route('pacient.store', [
            'cpf' => $faker->word,
            'name' => $pacient->name,
            'lastName' => $pacient->lastName,
            'phoneNumber' => $pacient->phoneNumber,
            'email' => $pacient->email,
            'password' => $pacient->password,
        ]));

        $response
            ->dump()
            ->assertStatus(422);

        $response = $this->call('POST', route('pacient.store', [
            'cpf' => rand(0,100),
            'name' => $pacient->name,
            'lastName' => $pacient->lastName,
            'phoneNumber' => $pacient->phoneNumber,
            'email' => $pacient->email,
        ]));

        $response
            ->dump()
            ->assertStatus(422);

        $response = $this->call('POST', route('pacient.store', [
            'cpf' => rand(100000000000, 999999999999),
            'name' => $pacient->name,
            'lastName' => $pacient->lastName,
            'phoneNumber' => $pacient->phoneNumber,
            'email' => $pacient->email,
        ]));

        $response
            ->dump()
            ->assertStatus(422);

        $response = $this->call('POST', route('pacient.store', [
            'cpf' => $pacient->cpf,
            'name' => rand(0,100),
            'lastName' => $pacient->lastName,
            'phoneNumber' => $pacient->phoneNumber,
            'email' => $pacient->email,
        ]));

        $response
            ->dump()
            ->assertStatus(422);

        $response = $this->call('POST', route('pacient.store', [
            'cpf' => $pacient->cpf,
            'name' => $pacient->lastName,
            'lastName' => rand(0,100),
            'phoneNumber' => $pacient->phoneNumber,
            'email' => $pacient->email,
        ]));

        $response
            ->dump()
            ->assertStatus(422);

        //--------------------------------------------------------

        //Success request
        $response = $this->call('POST', route('pacient.store', $pacient->toArray()));

        $id = json_decode($response->getContent())->data->id;
        $pacient = Pacient::find($id);

        $response
            ->dump()
            ->assertStatus(200)
            ->assertJson([
                'message' => 'Pacient created.',
                'data' => $pacient->toArray()
            ]);  
        //--------------------------------------------------------

        //Duplicated unique fields
        $response = $this->call('POST', route('pacient.store', $pacient->toArray()));

        $response
            ->dump()
            ->assertStatus(422);
    }

}
