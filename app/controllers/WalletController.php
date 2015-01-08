<?php

class WalletController extends BaseController {

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

        return View::make('wallet.home')->with($data);
    }

    public function showNewWallet()
    {
        $data = [];
        return View::make('wallet.new')->with($data);
    }

    public function createNewWallet()
    {
        //
    }

    public function showWallet($wallet)
    {
        $data = [];
        return View::make('wallet.edit')->with($data);
    }

    public function updateWallet($wallet)
    {
        //
    }

    public function showSendPayment()
    {
        $data = [];
        return View::make('wallet.send')->with($data);
    }

    public function sendPayment()
    {
        //
    }

    public function showReceivePayment($wallet)
    {
        $data = [];
        return View::make('wallet.receive')->with($data);
    }

}
