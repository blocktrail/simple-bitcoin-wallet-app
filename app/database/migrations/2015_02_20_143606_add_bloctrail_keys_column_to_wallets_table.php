<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBloctrailKeysColumnToWalletsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('wallets', function($table) {
			$table->text('blocktrail_keys')->nullable()->after('backup_mnemonic');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('wallets', function($table) {
			$table->dropColumn('blocktrail_keys');
		});
	}

}
