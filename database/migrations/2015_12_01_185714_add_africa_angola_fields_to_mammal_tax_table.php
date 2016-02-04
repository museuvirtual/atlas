<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAfricaAngolaFieldsToMammalTaxTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('mammal_taxonomy', function(Blueprint $table)
		{
			//
            $table->integer('africa')->nullable()->default(0);
            $table->integer('angola')->nullable()->default(0);
		});

        //UPDATE ANGOLA (and Africa) TO MATCHING FIELDS SEARCH FOR ANGOLA
        DB::select("UPDATE mammal_taxonomy SET africa=1, angola=1 WHERE type_locality
        ILIKE '%angola%' OR distribution ILIKE '%angola%' OR taxonomic_notes ILIKE '%angola%'");

        //UPDATE AAfrica TO MATCHING FIELDS SEARCH FOR Africa
        DB::select("UPDATE mammal_taxonomy SET africa=1 WHERE type_locality
        ILIKE '%africa%' OR distribution ILIKE '%africa%' OR taxonomic_notes ILIKE '%africa%'");
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
            $table->dropColumn('africa');
            $table->dropColumn('angola');
		});
	}

}
