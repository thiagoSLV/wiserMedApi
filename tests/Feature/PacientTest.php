<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PacientTest extends TestCase
{
    const API_URL = 'api/pacient/';
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetAll()
    {
        dd(route('pacient', 3));
        $response = $this->call('GET', self::API_URL);

        $response->assertStatus(200);
    }

    public function testGetById()
    {

        $response = $this->call('GET', self::API_URL, ['id' => 3]);
        dd($response->json());
        $response->assertStatus(200);
    }

}
