<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreatePacientsTable.
 */
class CreatePacientsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pacients', function(Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('cpf')->lenght(11);
            $table->string('name');
            $table->string('lastName');
            $table->integer('phoneNumber');
            $table->string('email');
            $table->string('password');

            $table->rememberToken();
            $table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('pacients');
	}
}
