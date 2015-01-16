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

        //1. first update any and all transaction confirmations
        $transactions = Transaction::where('tx_hash', $payload['data']['hash'])->get();
        $transactions->each(function($transaction) use($payload){
            $transaction->confirmations = $payload['data']['confirmations'];
            $transaction->save();
        });


        //2. If this webhook call is for a wallet receiving funds, we want to create a Transaction for it
        if ($wallet = Wallet::where('identity', $wallet_identity)->first()) {
            //check if a "received" transaction exists already and create it if not ("sent" transaction are created upon sending)
            $transactions = Transaction::where('tx_hash', $payload['data']['hash'])->where('wallet_id', $wallet->id)->where('direction', 'received')->get();
            if ($transactions->count() == 0) {
                //get the address and value change
                reset($payload['addresses']);
                $address = key($payload['addresses']);
                $amount = $payload['addresses'][$address];

                //determine the direction of the transaction (received or sent)
                if ($amount > 0) {
                    $direction = 'received';
                } else {
                    $direction = "sent";
                }
                $data = array(
                    'tx_hash' => $payload['data']['hash'],
                    'tx_time' => Carbon::parse($payload['data']['first_seen_at']),
                    'address' => $address,
                    'recipient' => null,                    //only used when sending transaction from this app
                    'direction' => $direction,
                    'amount' => $amount,
                    'confirmations' => $payload['data']['confirmations'],
                    'wallet_id' => $wallet->id,
                );

                $transaction = Transaction::create($data);
            }
        }

        return "webhook fired successfully";
    }

}
