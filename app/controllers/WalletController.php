<?php

class WalletController extends BaseController {

    private $bitcoinClient;

    public function __construct(Blocktrail $client) {
        $this->bitcoinClient = $client;
    }

    public function showDashboard()
    {
        //get the user's wallets and their balances
        $user = Auth::user();
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
        //validate input
        $rules = array(
            'name' => 'required',
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            //bad input
            return Redirect::route('wallet.create')->withErrors($validator);
        }

        //create new wallet
        $user = Auth::user();
        $walletData = array(
            'identity' => str_random(40),
            'name' => Input::get('name'),
            'pass' => str_random(6),
            'user_id' => $user->id
        );
        $wallet = New Wallet($walletData);
        if ($wallet->save()) {
            //wallet created - delete the backup mnemonic from the database
            Wallet::where('ID', $wallet->id)->update(array('backup_mnemonic' => null));
            $data = array(
                'newWallet' => $wallet
            );
            //return the view
            return View::make('wallet.new')->with($data);
        } else {
            //could not create wallet
            return View::make('wallet.new')->withErrors(Session::get('wallet-error'));
        }
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
