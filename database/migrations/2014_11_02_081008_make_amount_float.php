<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeAmountFloat extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('pays', function($t)
		{
			$t->dropColumn('amount');
		});
		Schema::table('pays', function($t)
		{
			$t->float('amount');
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
			$t->dropColumn('amount');
		});
		Schema::table('pays', function($t)
		{
			$t->integer('amount');
		});
	}

}
