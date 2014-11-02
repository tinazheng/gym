<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddActualPkToTransactions extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::drop('transactions');
		Schema::create('transactions', function($t)
		{
			$t->increments('id');
			$t->string('user_id', 100);
			$t->string('person_id', 100);
			$t->float('amount');
			$t->timestamps();
			$t->index('user_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('transactions');
		Schema::create('transactions', function($t)
		{
			$t->string('user_id', 100);
			$t->string('person_id', 100);
			$t->float('amount');
			$t->timestamps();
			$t->primary(array('user_id', 'person_id'));
			$t->index('user_id');
		});
	}

}
