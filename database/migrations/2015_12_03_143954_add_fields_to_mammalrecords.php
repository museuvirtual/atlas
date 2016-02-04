<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToMammalrecords extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('mammal_records', function(Blueprint $table)
		{
			//
            $table->boolean('roadkill')->default(false)->nullable();
            $table->text('comment')->nullable();
            $table->integer('numberindividuals')->nullable();

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('mammal_records', function(Blueprint $table)
		{
			//
            $table->dropColumn('roadkill');
            $table->dropColumn('comment');
            $table->dropColumn('numberindividuals');
		});
	}

}
