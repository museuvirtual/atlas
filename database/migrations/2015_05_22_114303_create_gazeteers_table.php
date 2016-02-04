<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGazeteersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

        Schema::create('locality_natures', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('nature');
            $table->string('description')->nullable();


        });
        Schema::create('coords_sources', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('source');
            $table->string('description')->nullable();
            $table->integer('gmaps_zoom')->nullable();


        });

        Schema::create('gazeteers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
            $table->integer('user_id');
            $table->string('locality_name')->index();
            $table->string('locality_name_alt')->nullable();;
            $table->string('locality_description')->nullable();;
            $table->string('locality_notes')->nullable();;
            $table->integer('locality_nature_id')->nullable();;
            $table->integer('province_id')->nullable();;
            $table->string('closest_town')->nullable();;

            $table->integer('coords_source_id')->nullable();;
            $table->integer('uncertainty_meters')->nullable();
            $table->string('uncertainty_description')->nullable();
            $table->string('locus')->nullable();


            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('coords_source_id')->references('id')->on('coords_sources')->onDelete('set null');
            $table->foreign('province_id')->references('gid')->on('provinces')->onDelete('set null');
            $table->foreign('locality_nature_id')->references('id')->on('locality_natures')->onDelete('set null');


		});
        DB::statement("ALTER TABLE gazeteers ADD COLUMN the_geom GEOMETRY(POINT, 4326)");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('gazeteers');
        Schema::drop('locality_natures');
        Schema::drop('coords_sources');


	}

}
