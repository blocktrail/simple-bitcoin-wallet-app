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

		//get the user's transaction history (last 20)
		$user->transactions = $user->transactions()->with(array('wallet' => function($query){
			$query->select(['id', 'name']);
		}))->orderBy('created_at', 'desc')->limit(20)->get();

		$data = array(
			'wallets' => $wallets,
			'transactions' => $user->transactions,
			'totalBalance' => $totalBalance,
			'totalUncBalance' => $totalUncBalance,
		);

		return View::make('dashboard.home')->with($data);
	}
}
