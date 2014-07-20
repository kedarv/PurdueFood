<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRatings extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('ratings', function($table) {
        $table->increments('id');
        $table->string('title', 255);
        $table->string('content', 255);
        $table->integer('user_id');
        $table->float('rating');
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
        Schema::drop('ratings');
	}

}
?>