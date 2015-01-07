<?php

class WalletController extends BaseController {

    private $bitcoinClient;

    public function __construct(Blocktrail $client) {
        $this->bitcoinClient = $client;
    }

    public function showDashboard()
    {
        return View::make('wallet.home');
    }

}
