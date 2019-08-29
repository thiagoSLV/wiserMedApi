<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Pacient;
class PacientTest extends TestCase
{

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetAll()
    {
        $response = $this->call('GET', route('pacient.all'));

        $response->assertStatus(200);
    }

    public function testGetById()
    {
        $pacient = factory(Pacient::class)->create();

        $response = $this->call('GET', route('pacient', ['id'=> $pacient->id]));

        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'name' => $pacient->name,
                'lastName' => $pacient->lastName,
                'cpf' => (int)$pacient->cpf,
                'phoneNumber' => $pacient->phoneNumber,
                'email' => $pacient->email,
            ])
            ->assertJson(['data' => $pacient->toArray()]);
        ;
    }

}
