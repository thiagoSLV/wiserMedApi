<?php

namespace Tests\Feature;

use App\Models\Appointment;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Faker\Factory;

class AppointmentTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetAll()
    {
        $url = 'appointment.all';
        $response = $this->call('GET', route($url));

        $response->assertStatus(200);
    }
    
    public function testGetById()
    {
        $url = 'appointment';
        $appointment = factory(appointment::class)->create();

        $response = $this->call('GET', route($url, ['id'=> $appointment->id]));

        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'doctor_id' => $appointment->doctor_id,
                'pacient_id' => $appointment->pacient_id,
                'procedure' => $appointment->procedure,
                'doctor_name' => $appointment->doctor->name,
                'doctor_lastName' => $appointment->doctor->lastName,
                'pacient_name' => $appointment->pacient->name,
                'pacient_lastName' => $appointment->pacient->lastName,
            ]);
    }

    public function testCreate()
    {
        $url = 'appointment.store';
        $appointment = factory(Appointment::class)->create();
        $faker = Factory::create('pt_BR');

        //Testing request without fields, bad request
        //--------------------------------------------------------
        $response = $this->call('POST', route($url, [
            'pacient_id' => rand(1, 25),
            'date' => date('Y-m-d', rand(time(), strtotime('+2 months'))),
            'time' => date('H:m', rand(strtotime('06:00'), strtotime('17:59'))),
            'price' => rand(0,50000) / 100,
            'procedure' => $faker->word,
        ]));
        
        $response
            ->dump()
            ->assertStatus(422);

        $response = $this->call('POST', route($url, [
            'doctor_id' => rand(1, 25),
            'date' => date('Y-m-d', rand(time(), strtotime('+2 months'))),
            'time' => date('H:m', rand(strtotime('06:00'), strtotime('17:59'))),
            'price' => rand(0,50000) / 100,
            'procedure' => $faker->word,
        ]));
        
        $response
            ->dump()
            ->assertStatus(422);

        $response = $this->call('POST', route($url, [
            'doctor_id' => rand(1, 25),
            'pacient_id' => rand(1, 25),
            'time' => date('H:m', rand(strtotime('06:00'), strtotime('17:59'))),
            'price' => rand(0,50000) / 100,
            'procedure' => $faker->word,
        ]));
        
        $response
            ->dump()
            ->assertStatus(422);

        $response = $this->call('POST', route($url, [
            'doctor_id' => rand(1, 25),
            'pacient_id' => rand(1, 25),
            'date' => date('Y-m-d', rand(time(), strtotime('+2 months'))),
            'price' => rand(0,50000) / 100,
            'procedure' => $faker->word,
        ]));
        
        $response
            ->dump()
            ->assertStatus(422);

        $response = $this->call('POST', route($url, [
            'doctor_id' => rand(1, 25),
            'pacient_id' => rand(1, 25),
            'date' => date('Y-m-d', rand(time(), strtotime('+2 months'))),
            'time' => date('H:m', rand(strtotime('06:00'), strtotime('17:59'))),
            'procedure' => $faker->word,
        ]));
        
        $response
            ->dump()
            ->assertStatus(422);

        $response = $this->call('POST', route($url, [
            'doctor_id' => rand(1, 25),
            'pacient_id' => rand(1, 25),
            'date' => date('Y-m-d', rand(time(), strtotime('+2 months'))),
            'time' => date('H:m', rand(strtotime('06:00'), strtotime('17:59'))),
            'price' => rand(0,50000) / 100,
        ]));
        
        $response
            ->dump()
            ->assertStatus(422);

        //Testing request with wrong data
        //--------------------------------------------------------

        $response = $this->call('POST', route($url, [
            'doctor_id' => $faker->word,
            'pacient_id' => rand(1, 25),
            'date' => date('Y-m-d', rand(time(), strtotime('+2 months'))),
            'time' => date('H:m', rand(strtotime('06:00'), strtotime('17:59'))),
            'price' => rand(0,50000) / 100,
            'procedure' => $faker->word,
        ]));
        
        $response
            ->dump()
            ->assertStatus(422);

        $response = $this->call('POST', route($url, [
            'doctor_id' => rand(1, 25),
            'pacient_id' => $faker->word,
            'date' => date('Y-m-d', rand(time(), strtotime('+2 months'))),
            'time' => date('H:m', rand(strtotime('06:00'), strtotime('17:59'))),
            'price' => rand(0,50000) / 100,
            'procedure' => $faker->word,
        ]));
        
        $response
            ->dump()
            ->assertStatus(422);

        $response = $this->call('POST', route($url, [
            'doctor_id' => rand(1, 25),
            'pacient_id' => rand(1, 25),
            'date' => $faker->word,
            'time' => date('H:m', rand(strtotime('06:00'), strtotime('17:59'))),
            'price' => rand(0,50000) / 100,
            'procedure' => $faker->word,
        ]));
        
        $response
            ->dump()
            ->assertStatus(422);

        $response = $this->call('POST', route($url, [
            'doctor_id' => rand(1, 25),
            'pacient_id' => rand(1, 25),
            'date' => date('Y-m-d', rand(time(), strtotime('+2 months'))),
            'time' => $faker->word,
            'price' => rand(0,50000) / 100,
            'procedure' => $faker->word,
        ]));
        
        $response
            ->dump()
            ->assertStatus(422);

        $response = $this->call('POST', route($url, [
            'doctor_id' => rand(1, 25),
            'pacient_id' => rand(1, 25),
            'date' => date('Y-m-d', rand(time(), strtotime('+2 months'))),
            'time' => date('H:m', rand(strtotime('06:00'), strtotime('17:59'))),
            'price' => $faker->word,
            'procedure' => $faker->word,
        ]));
        
        $response
            ->dump()
            ->assertStatus(422);

        $response = $this->call('POST', route($url, [
            'doctor_id' => rand(1, 25),
            'pacient_id' => rand(1, 25),
            'date' => date('Y-m-d', rand(time(), strtotime('+2 months'))),
            'time' => date('H:m', rand(strtotime('06:00'), strtotime('17:59'))),
            'price' => rand(0,50000) / 100,
            'procedure' => rand(1,100),
        ]));
        
        $response
            ->dump()
            ->assertStatus(422);

        //create duplicated date request
        //--------------------------------------------------------
        $response = $this->call('POST', route($url, [
            'doctor_id' => rand(1, 25),
            'pacient_id' => rand(1, 25),
            'date' => $appointment->date,
            'time' => $appointment->time,
            'price' => rand(0,50000) / 100,
            'procedure' => $faker->word,
        ]));
        
        $response
            ->dump()
            ->assertStatus(400);

        //success request
        //--------------------------------------------------------
        $appointment = factory(Appointment::class)->make();

        $response = $this->call('POST', route($url, $appointment->toArray()));

        $id = json_decode($response->getContent())->data->id;
        $appointment = array_filter(Appointment::find($id)->toArray());

        $response
            ->dump()
            ->assertStatus(200)
            ->assertJsonFragment([
                'message' => 'Appointment Registered.',
            ]);  
    }
}
