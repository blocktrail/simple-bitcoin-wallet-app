<?php

use Illuminate\Support\MessageBag;

class Transaction extends Eloquent {

	protected $bitcoinClient;

	protected $fillable = array(
		'tx_hash',
		'recipient',
		'direction',
		'amount',
		'confirmations',
		'wallet_id',
		'tx_time',
	);

	/*---Relations---*/
	public function wallet()
	{
		return $this->belongsTo('Wallet');
	}

}
