<?php

class HomeController extends BaseController {

	private $bitcoinClient;

	public function __construct(Blocktrail $client) {
		$this->bitcoinClient = $client;
	}

	public function showDashboard()
	{
		//get the user's wallets and their balances
		$user = User::find(Auth::user()->id);
		$wallets = $user->wallets;
		$wallets->each(function($wallet){
			$wallet->getBalance();
		});

		$data = array(
			'wallets' => $wallets
		);

		return View::make('dashboard.home')->with($data);
	}
}
