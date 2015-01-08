<?php

class WalletController extends BaseController {

    public function webhookCalled($address)
    {
        //get a new address to receive payments to
        $address = $wallet->getNewAddress();
        //create a webhook for new address
        $data = [];
        return View::make('wallet.receive')->with($data);
    }

}
