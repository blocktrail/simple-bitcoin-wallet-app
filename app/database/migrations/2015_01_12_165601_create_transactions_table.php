<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('transactions', function($table){
			$table->increments('id');
			$table->string('tx_hash');
			$table->string('address')->nullable();
			$table->string('recipient')->nullable();
			$table->string('direction');
			$table->integer('amount');
			$table->integer('confirmations');
			$table->integer('wallet_id');
			$table->datetime('tx_time');
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
		Schema::drop('transactions');
	}

}
