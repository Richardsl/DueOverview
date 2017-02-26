<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDueTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Due', function(Blueprint $table)
		{
			$table->increments('id');
			
			$table->string('boatId');
			$table->timestamp('storageDate');
			$table->integer('overdueCount')->nullable();
			$table->integer('overdueDays')->nullable();
			$table->unique(array('boatId','storageDate'));
						
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
		Schema::drop('Due');
	}

}
