<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUpdatedAtMammalTaxonomyTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('mammal_taxonomy', function(Blueprint $table)
		{
            $table->timestamp('updated_at')->nullable();
			//
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('mammal_taxonomy', function(Blueprint $table)
		{
			//
            $table->dropColumn('updated_at');
		});
	}

}
