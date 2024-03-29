<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PacientsTableSeeder::class);
        $this->call(DoctorsTableSeeder::class);
        $this->call(AppointmentsTableSeeder::class);
    }
}
