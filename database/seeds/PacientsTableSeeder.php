<?php

use App\Models\Pacient;
use Illuminate\Database\Seeder;

class PacientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factory(Pacient::class)->create([
        // 	'id' => 1,
        // 	'email' => 'teste@gmail.com',
        // 	'password' => 'abcde',
        // ]);
        factory(Pacient::class, 25)->create();
    }
}
