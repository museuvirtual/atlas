<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMammalRecordsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('mammal_records', function(Blueprint $table)
		{
            $table->bigInteger('id')->unsigned();
            $table->bigInteger('record_id')->unsigned();
            $table->timestamps();
            $table->integer('species_id')->nullable();
            $table->integer('user_created');
            $table->integer('user_updated')->nullable();
            $table->integer('user_deleted')->nullable();
            $table->integer('user_accepted')->nullable();
            $table->boolean('accepted')->default(False);
            $table->boolean('deleted')->default(False);
            $table->timestamp('date_deleted')->nullable();
            $table->string('reason_deleted')->nullable();
            $table->integer('sp_confirmed')->default(0);
            $table->integer('user_confirmed_sp')->nullable();
            $table->timestamp('date_confirmed')->nullable();
            $table->timestamp('date_observed');
            $table->integer('gazeteer_id');
            $table->integer('basis_of_record_id');
            $table->integer('institution_id')->nullable();
            $table->string('species_guessed_sc_name')->nullable();
            $table->string('species_guessed_commonName')->nullable();
            $table->integer('numPics');
            $table->integer('guessed_species_id')->nullable();

            $table->primary('id');

            $table->foreign('institution_id')->references('id')->on('institutions')->onDelete('set null');
            $table->foreign('gazeteer_id')->references('id')->on('gazeteers')->onDelete('set null');
            $table->foreign('species_id')->references('id')->on('mammal_taxonomy')->onDelete('set null');
            $table->foreign('basis_of_record_id')->references('id')->on('basis_of_records')->onDelete('set null');
            $table->foreign('user_created')->references('id')->on('users')->onDelete('set null');
            $table->foreign('user_updated')->references('id')->on('users')->onDelete('set null');
            $table->foreign('user_deleted')->references('id')->on('users')->onDelete('set null');
            $table->foreign('user_accepted')->references('id')->on('users')->onDelete('set null');
            $table->foreign('user_confirmed_sp')->references('id')->on('users')->onDelete('set null');
            $table->foreign('guessed_species_id')->references('id')->on('mammal_taxonomy')->onDelete('set null');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('mammal_records');
	}

}
