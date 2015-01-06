<?php

class WalletController extends BaseController {

    private $bitcoinClient;

    public function __construct() {

        //initialise the BlocTrail API
        $apiCredentials = Config::get('services.blocktrail', ['MY_API_KEY','MY_API_SECRET']);
        $apiKey = $apiCredentials['key'];
        $apiSecret = $apiCredentials['secret'];
        $currency = "btc";
        $this->bitcoinClient = new Blocktrail($apiKey, $apiSecret, $currency, false);
        $this->bitcoinClient->setCurlDefaultOption('verify', false); //disable ssl verification, for local testing
    }

    public function showDashboard()
    {
        return View::make('wallet.home');
    }

}
