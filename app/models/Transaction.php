<?php

use Illuminate\Support\MessageBag;

class Transaction extends Eloquent {

	protected $bitcoinClient;

	protected $fillable = array(
		'tx_hash',
		'address',
		'recipient',
		'direction',
		'amount',
		'confirmations',
		'wallet_id',
	);

	/*---Relations---*/
	public function wallet()
	{
		return $this->belongsTo('Wallet');
	}

}
