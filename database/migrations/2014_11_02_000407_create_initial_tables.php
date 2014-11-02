<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInitialTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('people', function($t)
		{
			$t->increments('id');
			$t->string('venmo_id', 50);
			$t->unique('venmo_id');
			$t->string('name', 100);
			$t->string('profile_picture_url', 200);
		});
		Schema::create('users', function($t)
		{
			$t->integer('person_id')->unsigned();
			$t->primary('person_id');
			$t->foreign('person_id')->references('id')->on('people');
			$t->integer('goal')->unsigned();
			$t->integer('progress')->unsigned();
		});
		//all the people that a user will pay
		Schema::create('pays', function($t)
		{
			$t->integer('user_id')->unsigned();
			$t->integer('person_id')->unsigned();
			$t->index('user_id');
			$t->unique(array('user_id', 'person_id'));
			$t->integer('amount');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('pays');
		Schema::drop('users');
		Schema::drop('people');
	}

}
