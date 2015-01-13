<?php

class WebhookController extends BaseController {

    public function webhookCalled($wallet_identity)
    {
        //get the raw POST data
        $request = Request::instance();
        $input = $request->getContent();
        $payload = json_decode($input, true);

        //get the wallet
        $wallet = Wallet::where('identity', $wallet_identity)->first();
        $transactions = Transaction::where('tx_hash', $payload['data']['hash'])->where('wallet_id', $wallet->id)->get();
        if ($transactions->count() > 0) {
            //update existing transaction confirmation counts for this wallet
            $transactions->each(function($transaction) use($payload){
                $transaction->confirmations = $payload['data']['confirmations'];
                $transaction->save();
            });
        } else {
            //workout the amount sent/received by the address
            //...
            $amount = -100;

            //determine the direction of the transaction (received or sent)
            //...
            $direction = 'received';
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
