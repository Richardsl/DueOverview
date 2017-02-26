<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTotalJobsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('totalJobs', function(Blueprint $table)
		{
			$table->increments('id');
			
			$table->integer('jobCount');
			$table->string('tmId');		
			$table->timestamp('storageDate');
			$table->unique(array('tmId','storageDate'));
			
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
		Schema::drop('totalJobs');
	}

}
