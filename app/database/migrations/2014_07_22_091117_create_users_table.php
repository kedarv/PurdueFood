<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table) {
			$table->increments('id');
			$table->string('username', 255);
			$table->string('email', 255);
			$table->string('password', 255);
			$table->string('confirmation_code', 255);
			$table->boolean('confirmed');
			$table->boolean('settingToggle_vegetarian')->nullable();
			$table->boolean('settingToggle_dairy')->nullable();
			$table->boolean('settingToggle_soy')->nullable();
			$table->boolean('settingToggle_egg')->nullable();
			$table->boolean('settingToggle_wheat')->nullable();
			$table->boolean('settingToggle_gluten')->nullable();
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
		Schema::drop('users');
	}

}
