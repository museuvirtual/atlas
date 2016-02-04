<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class InsertBasicData extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        DB::table('basis_of_records')->insert([array(
            'id' => 1,
            'code' => 'OB',
            'name' => 'Observações',
            'description' => 'Observações feitas e submetidas através do Museu Virtual por Cidadãos Cientistas',
            'glyphicon' => "<span class='glyphicon  glyphicon-eye-open' style='color:darkblue'></span>"

        ),array(
            'id' => 2,
            'code' => 'CT',
            'name' => 'Camera Trap',
            'description' => 'Observações feitas por meio de Camera Traps',
            'glyphicon' => '<span class="glyphicon  glyphicon-facetime-video" style="color:darkblue"></span>'

        ),array(
            'id' => 3,
            'code' => 'SP',
            'name' => 'Especimen em Coleção Histórica Museu',
            'description' => 'Museus',
            'glyphicon' => '<span class="glyphicon glyphicon glyphicon-tower" style="color:darkblue"></span>'

        ),array(
            'id' => 4,
            'code' => 'HR',
            'name' => 'Registo Histórico',
            'description' => 'Revisão bibliográfica, registos antigos sem especimens',
            'glyphicon' => '<span class="glyphicon glyphicon glyphicon-tower" style="color:darkblue"></span>'

        )]);

        DB::table('coords_sources')->insert([array(
            'id' => 1,
            'source' => 'GPS',
            'description' => 'GPS Pessoal'

        ),array(
            'id' => 2,
            'source' => 'Georreferenciação',
            'description' => 'Georreferenciação de localidades descritas'

        ),array(
            'id' => 3,
            'source' => 'Google Maps',
            'description' => 'Google maps ou similar'

        )]);

        DB::table('locality_natures')->insert([array(
            'id' => 1,
            'nature' => 'Rio',
            'description' => 'Rio'

        ),array(
            'id' => 2,
            'nature' => 'Vila',
            'description' => 'Vila'

        ),array(
            'id' => 3,
            'nature' => 'Cidade',
            'description' => 'Cidade'

        ),array(
            'id' => 4,
            'nature' => 'Estrada',
            'description' => 'Estrada'

        ),array(
            'id' => 5,
            'nature' => 'Caminho',
            'description' => 'Caminho'

        ),array(
            'id' => 6,
            'nature' => 'Praia',
            'description' => 'Praia'

        ),array(
            'id' => 7,
            'nature' => 'Outro',
            'description' => 'Outro'

        )]);

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
