<?php

use Illuminate\Database\Seeder;
use App\Models\Doctor;

class DoctorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Doctor::class, 25)->create([
            // 'latitude' => -5.973402,
            // 'longitude' => -56.192980
        ]);

        factory(Doctor::class)->create([
            'name' => 'Doutor',
            'lastName' => 'Teste',
        	'email' => 'doutor@teste.com',
        	'password' => Hash::make(123),
        ]);
    }
}
