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
				$newWebhook = $bitcoinClient->setupWebhook($model->url, $model->identifier);
			}
			catch (Exception $e) {
				//an error occured - add to any existing errors and flash to session
				$errors =  new MessageBag();
				$errors->add('general', 'Could not create webhook - '.$e->getMessage());
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

}
