<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManTreeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pks_ManTree', function(Blueprint $table)
		{
			$table->integer('CNO')->index('IX_ManTree');
			$table->smallInteger('SType')->index('IX_ManTree_3');
			$table->integer('Man_Code')->index('IX_ManTree_2');
			$table->integer('GDCode')->index('IX_ManTree_1');
			$table->integer('LV')->index('IX_ManTree_4');
			$table->integer('OCT')->index('IX_ManTree_6');
			$table->integer('PCode')->nullable()->index('IX_ManTree_5');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('pks_ManTree');
	}

}
