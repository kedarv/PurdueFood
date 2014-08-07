<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFollowersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('followers', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('follower_user_id')->nullable();
            $table->integer('target_user_id')->nullable();
            $table->integer('following')->nullable();
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
        Schema::drop('followers');
	}

}
