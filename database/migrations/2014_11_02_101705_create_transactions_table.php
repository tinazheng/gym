<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('pays', function($t)
		{
			$t->dropUnique('pays_user_id_person_id_unique');
			$t->primary(array('user_id', 'person_id'));
		});
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

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('pays', function($t)
		{
			$t->dropPrimary('pays_user_id_person_id_primary');
			$t->unique(array('user_id', 'person_id'));
		});
		Schema::drop('transactions');
	}

}
