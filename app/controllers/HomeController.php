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
		//lets also add up the balances of all wallets
		$totalBalance = 0;
		$totalUncBalance = 0;
		$wallets->each(function($wallet) use(&$totalBalance, &$totalUncBalance){
			$wallet->getBalance();
			$totalBalance += $wallet->balance;
			$totalUncBalance += $wallet->unc_balance;
		});
		
		$data = array(
			'wallets' => $wallets,
			'totalBalance' => $totalBalance,
			'totalUncBalance' => $totalUncBalance,
		);

		return View::make('dashboard.home')->with($data);
	}
}
