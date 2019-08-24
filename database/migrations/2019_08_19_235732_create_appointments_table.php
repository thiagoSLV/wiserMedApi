<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateAppointmentsTable.
 */
class CreateAppointmentsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('appointments', function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('doctor_id');
            $table->unsignedInteger('pacient_id');
            $table->date('Date');
            $table->time('Time');

            $table->timestamps();

            $table->foreign('doctor_id')->references('id')->on('doctors');
            $table->foreign('pacient_id')->references('id')->on('pacients');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('appointments');
	}
}
