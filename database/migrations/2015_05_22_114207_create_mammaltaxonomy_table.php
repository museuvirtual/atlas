<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMammaltaxonomyTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('mammal_taxonomy', function(Blueprint $table)
		{
			$table->integer('id');
            $table->string('scientific_name');
            $table->string('common_name_en')->nullable();
            $table->string('common_name_pt')->nullable();
            $table->string('common_name_alt')->nullable();
            $table->string('kingdom')->nullable();
            $table->string('phylum')->nullable();
            $table->string('class')->nullable();
            $table->string('subclass')->nullable();
            $table->string('order')->nullable();
            $table->string('suborder')->nullable();
            $table->string('infraorder')->nullable();
            $table->string('superfamily')->nullable();
            $table->string('family')->nullable();
            $table->string('subfamily')->nullable();
            $table->string('tribe')->nullable();
            $table->string('genus')->nullable();
            $table->string('subgenus')->nullable();
            $table->string('species')->nullable();
            $table->string('subspecies')->nullable();
            $table->string('taxonomic_authority')->nullable();
            $table->string('type_locality',512)->nullable();
            $table->string('red_data_status',1000)->nullable();
            $table->string('distribution',2500)->nullable();
            $table->string('author_name')->nullable();
            $table->text('taxonomic_notes')->nullable();
            $table->string('datasource')->nullable();
            $table->integer('external_id(msw)')->nullable();
            $table->string('recon_notes')->nullable();
            $table->string('notes')->nullable();
            $table->boolean('deleted')->nullable();
            $table->string('deleted_by')->nullable();
            $table->string('reason_deleted')->nullable();
            $table->boolean('hide')->nullable();
            $table->string('id_level')->nullable();
            $table->string('vm_old_sp_code')->nullable();
            $table->integer('printed_date')->nullable();
            $table->integer('true_date')->nullable();

            $table->primary('id');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('mammal_taxonomy');
	}

}
