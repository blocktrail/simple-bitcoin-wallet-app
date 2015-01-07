<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWalletsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('wallets', function($table){
			$table->increments('id');
			$table->string('identity')->unique();
			$table->string('pass');
			$table->text('primary_mnemonic');
			$table->text('backup_mnemonic')->nullable();	//only store backup mnemonic temporarily, until displayed to user
			$table->integer('user_id');
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
		Schema::drop('wallets');
	}

}
