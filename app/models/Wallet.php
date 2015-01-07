<?php

//use Blocktrail\SDK\Connection\Exceptions\WalletExistsError;	//error doesn't exist yet

class Wallet extends Eloquent {

	protected $bitcoinClient;
	protected $liveWallet;

	protected $fillable = array(
		'identity',
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
				list($wallet, $backupKey) = $bitcoinClient->createNewWallet($model->identity, $model->pass);
				//$model->primary_mnemonic = $primaryMnenomic;		//cannot access primary key mnemonic yet. Will include later
				$model->backup_mnemonic = $backupKey;
			}
			/*
			catch (WalletExistsError $e) {
				//if already exists, attempt to initialise it (ensures pass is correct)
				//all good to go, save model to DB
				//could not initialise, don't save this model
				return false;
			}
			*/
			catch (Exception $e) {
				//if already exists, attempt to initialise it (ensures pass is correct)
				//all good to go, save model to DB
				//could not initialise, don't save this model
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
