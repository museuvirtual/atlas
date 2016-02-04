<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollectorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('collectors', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name');
            $table->string('surname');
            $table->timestamps();
            $table->integer('user_id')->nullable();




        });


        Schema::create('collector_mammal_record', function(Blueprint $table)
        {
            $table->increments('id');
            $table->timestamps();
            $table->bigInteger('mammalRecord_id')->unsigned()->index();
            $table->foreign('mammalRecord_id')->references('id')->on('mammal_records')->onDelete('set null');

            $table->Integer('collector_id')->unsigned()->index();
            $table->foreign('collector_id')->references('id')->on('collectors')->onDelete('set null');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('collector_mammal_record');
        Schema::drop('collectors');

	}

}
