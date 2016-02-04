<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProvincesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('provinces', function(Blueprint $table)
		{
			$table->increments('gid');
            $table->integer('id');
            $table->string('country');
            $table->string('province');
            $table->string('municipe');
		});
        DB::statement("ALTER TABLE provinces ADD COLUMN geom GEOMETRY(MULTIPOLYGON, 0)");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('provinces');
	}

}