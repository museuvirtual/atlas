<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBasisOfRecordsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('basis_of_records', function(Blueprint $table)
		{
            $table->increments('id');
            $table->string('code');
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('glyphicon')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('basis_of_records');
	}

}
