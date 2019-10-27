<?php

use Illuminate\Database\Seeder;
use App\Models\Appointment;

class AppointmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Appointment::class, 25)->create();

        factory(Appointment::class, 3)->create([
            'pacient_id' => 26,
            'doctor_id' => 26,
        ]);


    }
}
