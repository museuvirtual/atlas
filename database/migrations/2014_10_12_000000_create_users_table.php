<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
            $table->increments('id');
            $table->string('name');
            $table->string('surname');
            $table->string('email')->unique();
            $table->string('password', 60);
            $table->integer('level')->default(0); // 0 -> Regular User, 1-> Advanced user 2-> Administrator
            $table->boolean('mammalExpert')->default(False);
            $table->boolean('confirmed')->default(False);
            $table->boolean('deleted')->default(False);
            $table->text('notes')->nullable();
            $table->binary('picture')->nullable();
            $table->rememberToken();
            $table->timestamps();

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
