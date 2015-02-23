<?php

use Illuminate\Support\MessageBag;

class Webhook extends Eloquent {

	protected $bitcoinClient;

	protected $fillable = array(
		'identifier',
		'url',
		'wallet_id',
		'last_call'
	);

	public function __construct($attributes = array()) {
		parent::__construct($attributes);

		//initialise the bitcoin client
		$this->bitcoinClient = App::make('Blocktrail');
	}

	public static function boot()
	{
		parent::boot();

		static::saving(function($model)
		{
			$bitcoinClient = App::make('Blocktrail');
			//attempt to create the remote webhook first
			try {
				//if a wallet is associated with this webhook, create a wallet webhook
				if ($model->wallet) {
					$newWebhook = $bitcoinClient->setupWalletWebhook($model->wallet->identity, $model->identifier, $model->url);
				} else {
					$newWebhook = $bitcoinClient->setupWebhook($model->url, $model->identifier);
				}
			}
			catch (Exception $e) {
				//an error occured - add to any existing errors and flash to session
				$errors =  new MessageBag();
				$errors->add('general', 'Could not create webhook - '.$e->getMessage());
				Session::flash('webhook-error', $errors);
				return false;
			}
		});

		static::deleting(function($model)
		{
			$bitcoinClient = App::make('Blocktrail');
			//attempt to delete the remote webhook first
			try {
				//if a wallet is associated with this webhook, delete the wallet webhook
				if ($model->wallet) {
					$result = $bitcoinClient->deleteWalletWebhook($model->wallet->identity, $model->identifier);
				} else {
					$result = $bitcoinClient->deleteWebhook($model->identifier);
				}
			}
			catch (Exception $e) {
				//an error occurred - add to any existing errors and flash to session
				$errors =  new MessageBag();
				$errors->add('general', 'Could not delete webhook - '.$e->getMessage());
				Session::flash('webhook-error', $errors);
				return false;
			}
		});
	}


	/*---Relations---*/
	public function wallet()
	{
		return $this->belongsTo('Wallet');
	}

	/*---other functions---*/
	public function subscribeAddressTransactions($address, $confirmations = 6)
	{
		return $this->bitcoinClient->subscribeAddressTransactions($this->identifier, $address, $confirmations);
	}

}
