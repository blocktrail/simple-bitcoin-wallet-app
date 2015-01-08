<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebhooksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('webhooks', function($table){
			$table->increments('id');
			$table->string('identifier')->unique();
			$table->integer('wallet_id');
			$table->string('url');
			$table->dateTime('last_call')->nullable();
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
		Schema::drop('webhooks');
	}

}
