<?php

namespace Tests\Feature;

use App\Models\Appointment;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Faker\Factory;


class AppointmentTest extends TestCase
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
        $route = 'appointment.all';
        $response = $this->call('GET', route($route));

        $response->assertStatus(200);
    }
    
    public function testGetById()
    {
        $route = 'appointment';
        $appointment = factory(appointment::class)->create();

        $response = $this->call('GET', route($route, ['id'=> $appointment->id]));

        //Success request
        //------------------------------------------------------------------------
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

        //Wrong id format
        //------------------------------------------------------------------------
        $response = $this->call('GET', route($route, 'string'));

        $response
            ->dump()
            ->assertStatus(400);
    }

    public function testCreate()
    {
        $route = 'appointment.store';
        $appointment = factory(Appointment::class)->create();
        $faker = Factory::create('pt_BR');

        //Testing request without fields, bad request
        //--------------------------------------------------------
        $response = $this->call('POST', route($route, [
            'pacient_id' => rand(1, 25),
            'date' => date('Y-m-d', rand(time(), strtotime('+2 months'))),
            'time' => date('H:m', rand(strtotime('06:00'), strtotime('17:59'))),
            'price' => rand(0,50000) / 100,
            'procedure' => $faker->word,
        ]));
        
        $response
            ->dump()
            ->assertStatus(422);

        $response = $this->call('POST', route($route, [
            'doctor_id' => rand(1, 25),
            'date' => date('Y-m-d', rand(time(), strtotime('+2 months'))),
            'time' => date('H:m', rand(strtotime('06:00'), strtotime('17:59'))),
            'price' => rand(0,50000) / 100,
            'procedure' => $faker->word,
        ]));
        
        $response
            ->dump()
            ->assertStatus(422);

        $response = $this->call('POST', route($route, [
            'doctor_id' => rand(1, 25),
            'pacient_id' => rand(1, 25),
            'time' => date('H:m', rand(strtotime('06:00'), strtotime('17:59'))),
            'price' => rand(0,50000) / 100,
            'procedure' => $faker->word,
        ]));
        
        $response
            ->dump()
            ->assertStatus(422);

        $response = $this->call('POST', route($route, [
            'doctor_id' => rand(1, 25),
            'pacient_id' => rand(1, 25),
            'date' => date('Y-m-d', rand(time(), strtotime('+2 months'))),
            'price' => rand(0,50000) / 100,
            'procedure' => $faker->word,
        ]));
        
        $response
            ->dump()
            ->assertStatus(422);

        $response = $this->call('POST', route($route, [
            'doctor_id' => rand(1, 25),
            'pacient_id' => rand(1, 25),
            'date' => date('Y-m-d', rand(time(), strtotime('+2 months'))),
            'time' => date('H:m', rand(strtotime('06:00'), strtotime('17:59'))),
            'procedure' => $faker->word,
        ]));
        
        $response
            ->dump()
            ->assertStatus(422);

        $response = $this->call('POST', route($route, [
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

        $response = $this->call('POST', route($route, [
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

        $response = $this->call('POST', route($route, [
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

        $response = $this->call('POST', route($route, [
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

        $response = $this->call('POST', route($route, [
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

        $response = $this->call('POST', route($route, [
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

        $response = $this->call('POST', route($route, [
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
        $response = $this->call('POST', route($route, [
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

        $response = $this->call('POST', route($route, $appointment->toArray()));

        $id = json_decode($response->getContent())->data->id;
        $appointment = array_filter(Appointment::find($id)->toArray());

        $response
            ->dump()
            ->assertStatus(200)
            ->assertJsonFragment([
                'message' => 'Appointment Registered.',
            ]);  
    }

    public function testGetByRange()
    {

        $init = date('Y-m-d', time());
        $fin = date('Y-m-d', strtotime('+1 months'));
        $route = 'appointment.date.range';

        factory(Appointment::class, 6)->create([
            'date' => date('Y-m-d', rand(time(), strtotime('+15 days'))),
            'procedure' => 'teste',
        ]);

        //Success request
        //--------------------------------------------------------------

        $response = $this->call('GET', route($route, [$init, $fin]));

        $response
            ->dump()
            ->assertJsonFragment(['procedure' => 'teste'])
            ->assertStatus(200);

        //Wrong date format
        //--------------------------------------------------------------
        
        $response = $this->call('GET', route($route, [1, $fin]));

        $response
            ->dump()
            ->assertStatus(400);
        
        $response = $this->call('GET', route($route, [$init, 1]));

        $response
            ->dump()
            ->assertStatus(400);

        $response = $this->call('GET', route($route, [$fin, $init]));

        $response
            ->dump()
            ->assertStatus(200);
    }

    public function testGetPacientAppointments()
    {
        $route = 'appointment.pacient';

        factory(Appointment::class, 4)->create([
            'date' => date('Y-m-d', rand(time(), strtotime('+15 days'))),
            'procedure' => 'get',
            'pacient_id' => 1
        ]);

        factory(Appointment::class, 4)->create([
            'date' => date('Y-m-d', rand(time(), strtotime('+15 days'))),
            'procedure' => 'dont get',
            'pacient_id' => 2
        ]);

        //Wrong id format
        //------------------------------------------------------------------------
        $response = $this->call('GET', route($route, 'string'));

        $response
            ->dump()
            ->assertStatus(400);

        //Success Request
        //------------------------------------------------------------------------
        $response = $this->call('GET', route($route, 1)); //User already in database by docker entrypoint (application.sh)

        $response
            ->dump()
            ->assertJsonFragment(['procedure' => 'get'])
            ->assertJsonMissing(['procedure' => 'dont get'])
            ->assertStatus(200);
    }

    public function testGetDoctorAppointments()
    {
        $route = 'appointment.doctor';

        factory(Appointment::class, 4)->create([
            'date' => date('Y-m-d', rand(time(), strtotime('+15 days'))),
            'procedure' => 'get',
            'doctor_id' => 1
        ]);

        factory(Appointment::class, 4)->create([
            'date' => date('Y-m-d', rand(time(), strtotime('+15 days'))),
            'procedure' => 'dont get',
            'doctor_id' => 2
        ]);

        //Wrong id format
        //------------------------------------------------------------------------
        $response = $this->call('GET', route($route, 'string'));

        $response
            ->dump()
            ->assertStatus(400);

        //Success Request
        //------------------------------------------------------------------------
        $response = $this->call('GET', route($route, 1)); //User already in database by docker entrypoint (application.sh)

        $response
            ->dump()
            ->assertJsonFragment(['procedure' => 'get'])
            ->assertJsonMissing(['procedure' => 'dont get'])
            ->assertStatus(200);
    }

    public function testGetPacientAppointmentsByDateRange()
    {
        $init = date('Y-m-d', time());
        $fin = date('Y-m-d', strtotime('+1 months'));
        $route = 'appointment.pacient.date.range';

        factory(Appointment::class, 3)->create([
            'date' => date('Y-m-d', rand(time(), strtotime('+15 days'))),
            'procedure' => 'get',
            'pacient_id' => 1,
        ]);

        factory(Appointment::class, 3)->create([
            'date' => date('Y-m-d', rand(time(), strtotime('+15 days'))),
            'procedure' => 'get',
            'pacient_id' => 2,
        ]);
        $init = date('Y-m-d', time());
        $fin = date('Y-m-d', strtotime('+1 months'));
        $route = 'appointment.pacient.date.range';

        factory(Appointment::class, 3)->create([
            'date' => date('Y-m-d', rand(time(), strtotime('+15 days'))),
            'procedure' => 'get',
            'pacient_id' => 1,
        ]);

        factory(Appointment::class, 3)->create([
            'date' => date('Y-m-d', rand(time(), strtotime('+15 days'))),
            'procedure' => 'get',
            'pacient_id' => 2,
        ]);

        //Success request
        //--------------------------------------------------------------

        $response = $this->call('GET', route($route, [1, $init, $fin]));

        $response
            ->dump()
            ->assertJsonFragment(['procedure' => 'get'])
            ->assertJsonMissing(['procedure' => 'dont get'])
            ->assertStatus(200);

        //Wrong date format
        //--------------------------------------------------------------
        
        $response = $this->call('GET', route($route, [1, 1, $fin]));

        $response
            ->dump()
            ->assertStatus(400);
        
        $response = $this->call('GET', route($route, [1, $init, 1]));

        $response
            ->dump()
            ->assertStatus(400);

        $response = $this->call('GET', route($route, [1, $fin, $init]));

        $response
            ->dump()
            ->assertStatus(200);

        //Wrong id format
        //------------------------------------------------------------------------
        $response = $this->call('GET', route($route, ['string', $fin, $init]));

        $response
            ->dump()
            ->assertStatus(400);
        //Success request
        //--------------------------------------------------------------

        $response = $this->call('GET', route($route, [1, $init, $fin]));

        $response
            ->dump()
            ->assertJsonFragment(['procedure' => 'get'])
            ->assertJsonMissing(['procedure' => 'dont get'])
            ->assertStatus(200);

        //Wrong date format
        //--------------------------------------------------------------
        
        $response = $this->call('GET', route($route, [1, 1, $fin]));

        $response
            ->dump()
            ->assertStatus(400);
        
        $response = $this->call('GET', route($route, [1, $init, 1]));

        $response
            ->dump()
            ->assertStatus(400);

        $response = $this->call('GET', route($route, [1, $fin, $init]));

        $response
            ->dump()
            ->assertStatus(200);

        //Wrong id format
        //------------------------------------------------------------------------
        $response = $this->call('GET', route($route, ['string', $fin, $init]));

        $response
            ->dump()
            ->assertStatus(400);
    }

    public function testGetDoctorAppointmentsByDateRange()
    {
        $init = date('Y-m-d', time());
        $fin = date('Y-m-d', strtotime('+1 months'));
        $route = 'appointment.doctor.date.range';

        factory(Appointment::class, 3)->create([
            'date' => date('Y-m-d', rand(time(), strtotime('+15 days'))),
            'procedure' => 'get',
            'doctor_id' => 1,
        ]);

        factory(Appointment::class, 3)->create([
            'date' => date('Y-m-d', rand(time(), strtotime('+15 days'))),
            'procedure' => 'get',
            'doctor_id' => 2,
        ]);

        //Success request
        //--------------------------------------------------------------

        $response = $this->call('GET', route($route, [1, $init, $fin]));

        $response
            ->dump()
            ->assertJsonFragment(['procedure' => 'get'])
            ->assertJsonMissing(['procedure' => 'dont get'])
            ->assertStatus(200);

        //Wrong date format
        //--------------------------------------------------------------
        
        $response = $this->call('GET', route($route, [1, 1, $fin]));

        $response
            ->dump()
            ->assertStatus(400);
        
        $response = $this->call('GET', route($route, [1, $init, 1]));

        $response
            ->dump()
            ->assertStatus(400);

        $response = $this->call('GET', route($route, [1, $fin, $init]));

        $response
            ->dump()
            ->assertStatus(200);

        //Wrong id format
        //------------------------------------------------------------------------
        $response = $this->call('GET', route($route, ['string', $fin, $init]));

        $response
            ->dump()
            ->assertStatus(400);
    }
}



