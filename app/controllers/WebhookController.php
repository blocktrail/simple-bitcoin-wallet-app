<?php

class WebhookController extends BaseController {

    public function webhookCalled($wallet_identity)
    {
        //get the raw POST data
        $request = Request::instance();
        $input = $request->getContent();
        $payload = json_decode($input, true);

        //--------------------------------TESTING--------------------------------
        //for now also save the whole input to our DB...just for testing
        DB::table('test')->insert(array('data' => $input));
        //--------------------------------/TESTING--------------------------------

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
            //get the address and value change
            list($address, $amount) = $payload['addresses'][0];

            //determine the direction of the transaction (received or sent)
            if ($amount > 0) {
                $direction = 'received';
            } else {
                $direction = "sent";
            }
            $data = array(
                'tx_hash' => $payload['data']['hash'],
                'address' => $address,
                'recipient' => null,                    //only used when sending transaction from this app
                'direction' => $direction,
                'amount' => $amount,
                'confirmations' => $payload['data']['confirmations'],
                'wallet_id' => $wallet->id,
            );

            $transaction = Transaction::create($data);
        }

        return "webhook fired successfully";
    }

}
