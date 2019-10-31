<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateDoctorsTable.
 */
class CreateDoctorsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('doctors', function(Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('cpf')->lenght(11)->nullable();
            $table->bigInteger('cnpj')->lenght(14)->nullable();
            $table->string('name');
            $table->string('lastName');
            $table->string('specialty');
            $table->string('address');
            $table->decimal('latitude', 8,6);
            $table->decimal('longitude', 9,6);
            $table->integer('crm');
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
		Schema::drop('doctors');
	}
}
