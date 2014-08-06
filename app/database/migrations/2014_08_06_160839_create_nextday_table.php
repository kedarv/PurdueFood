<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNextdayTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('nextday', function(Blueprint $table) {
			$table->increments('id');
			$table->string('food_id', 45);
			$table->string('food_name', 255);
			$table->string('hall', 255);
			$table->string('station', 255);
			$table->string('meal', 255);
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
		  Schema::drop('nextday');
	}

}
