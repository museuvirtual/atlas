<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpConfirmationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sp_confirmations', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->timestamps();
            $table->bigInteger('mammal_record_id')->unsigned();
            $table->integer('mammal_taxonomy_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->text('comments');

            $table->foreign('mammal_record_id')->references('id')->on('mammal_records')->onDelete('set null');
            $table->foreign('mammal_taxonomy_id')->references('id')->on('mammal_taxonomy')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');



        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('sp_confirmations');
	}

}
