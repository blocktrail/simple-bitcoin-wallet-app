<?php

class WebhookController extends BaseController {

    public function webhookCalled($wallet_identity)
    {
        //get the raw POST data
        $request = Request::instance();
        $input = $request->getContent();
        $payload = json_decode($input, true);

        if ($transaction = Transaction::where('tx_hash', $payload['data']['hash'])->first()) {
            //update existing transaction confirmation count
            $transaction->confirmations = $payload['data']['confirmations'];
            $transaction->save();
        } else {
            //get the wallet
            $wallet = Wallet::where('identity', $wallet_identity)->first();

            //workout the amount sent/received by the address
            //...
            $amount = -100;

            //determine the direction of the transaction (receive or send)
            //...
            $direction = 'receive';
            $data = array(
                'tx_hash' => $payload['data']['hash'],
                'address' => 'none',    //$payload['data']['address'],    //not yet implemented in the webhook api
                'recipient' => null,                    //only used when sending transaction from this app
                'direction' => $direction,
                'amount' => $amount,
                'confirmations' => $payload['data']['confirmations'],
                'wallet_id' => $wallet->id,
            );

            $transaction = Transaction::create($data);
        }
        return $transaction;
    }

}
