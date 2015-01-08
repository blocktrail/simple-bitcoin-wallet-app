<?php

//use Blocktrail\SDK\Connection\Exceptions\WalletExistsError;	//error doesn't exist yet
use Illuminate\Support\MessageBag;

class Wallet extends Eloquent {

	protected $bitcoinClient;
	protected $liveWallet;

	protected $fillable = array(
		'identity',
		'name',
		'pass',
		'user_id'
	);

	public static $rules = array(
		'identity' 	=> 'alphanum|required',
		'pass'   	=> 'required|min:3',
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
			//attempt to create the remote wallet first
			try {
				list($wallet, $backupPhrase) = $bitcoinClient->createNewWallet($model->identity, $model->pass);
				//$model->primary_mnemonic = $primaryMnenomic;		//cannot access primary key mnemonic yet. Will include later
				$model->backup_mnemonic = $backupPhrase;
			}
			/*
			catch (WalletExistsError $e) {
				//if already exists, attempt to initialise it (ensures pass is correct)
				//all good to go, save model to DB

				//could not initialise, don't save this model
				Session::flash('errors', 'a wallet with the same identity exists. please try again');
				return false;
			}
			*/
			catch (Exception $e) {
				//an error occured - add to any existing errors and flash to session
				$errors =  new MessageBag();
				$errors->add('general', 'Could not create wallet - '.$e->getMessage());
				Session::flash('wallet-error', $errors);
				return false;
			}
		});
	}


	/*---Relations---*/
	public function user()
	{
		return $this->belongsTo('User');
	}

	/*---Accessors and Mutators---*/
	public function setPasswordAttribute($value)
	{
		$this->attributes['password'] = Hash::make($value);
	}

	/*--- Other functions ---*/
	public function initLiveWallet() {
		$this->liveWallet = $this->bitcoinClient->initWallet($this->identity, $this->pass);
	}

	public function getBalance() {
		if(!$this->liveWallet) {
			$this->initLiveWallet();
		}
		list($this->balance, $this->unc_balance) = $this->liveWallet->getBalance();
	}

}
