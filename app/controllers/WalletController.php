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
        return View::make('wallet.new');
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

            //create a webhook for this wallet
            if (App::environment('production')) {
                $url = URL::route('webhook', array('wallet_identity' => $wallet->identity));
            } else {
                //can't use http://localhost, must use a reachable URI. Use a Runscope URL for simple testing
                $url = "https://serene-mesa-9890.herokuapp.com/webhook-test";
            }
            $newWebhook = Webhook::create(array('identifier' => $wallet->identity, 'url' => $url, 'wallet_id' => $wallet->id));

            //return the view with new wallet data
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
        //get a new address to receive payments to
        $address = $wallet->getNewAddress();
        //create a webhook event listening to the new address
        $wallet->webhook->subscribeAddressTransactions($address);
        $data = [
            'wallet' => $wallet,
            'address' => $address
        ];
        return View::make('wallet.receive')->with($data);
    }

    public function sendPaymentRequest($wallet)
    {
        //validate input
        $rules = array(
            'email' => 'required|email',
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            //bad input
            $data = [
                'wallet' => $wallet,
                'address' => Input::get('address')
            ];
            return View::make('wallet.receive')->with($data)->withInput(Input::all())->withErrors($validator);
        }

        //success
        return View::make('wallet.request-sent')->with($data);
    }

}
