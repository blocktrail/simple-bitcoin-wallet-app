<?php

class WebhookController extends BaseController {

    public function webhookCalled($wallet_identity)
    {
        //get the raw POST data
        $request = Request::instance();
        $input = $request->getContent();
        $payload = json_decode($input, true);

        //1. first update any and all transaction confirmations
        $transactions = Transaction::where('tx_hash', $payload['data']['hash'])->get();
        $transactions->each(function($transaction) use($payload){
            $transaction->confirmations = $payload['data']['confirmations'];
            $transaction->save();
        });
        
        //2. now create transaction entries for our wallet's involvement in this Bitcoin transaction
        //if no transaction exists for this tx and address, create a new one
        if ($wallet = Wallet::where('identity', $wallet_identity)->first()) {
            $transactions = Transaction::where('tx_hash', $payload['data']['hash'])
                ->where('wallet_id', $wallet->id)
                ->get();
            if ($transactions->count() == 0) {
                //determine the direction of the transaction (received or sent)
                $recipient = null;
                $address = null;
                if ($payload['wallet']['balance'] > 0) {
                    $direction = 'received';
                    $address = null;            //can't know "who" sent this transaction
                } else {
                    //the address sent funds - we can't tell who to, but if it's through this wallet then it should already be handled
                    $direction = "sent";
                }
                $data = array(
                    'tx_hash' => $payload['data']['hash'],
                    'tx_time' => Carbon::parse($payload['data']['first_seen_at']),
                    'address' => $address,
                    'recipient' => $recipient,
                    'direction' => $direction,
                    'amount' => $payload['wallet']['balance'],
                    'confirmations' => $payload['data']['confirmations'],
                    'wallet_id' => $wallet->id,
                );

                $transaction = Transaction::create($data);
            } else {
                //there is already an entry for this transaction, but we want to ensure it's not being sent back to this wallet
                // - so if this is a 'sent' tx, check the recipient against the addresses in the payload to see if this is actually an internal tx
                if ($transactions[0]->direction == "sent") {
                    foreach ($payload['wallet']['addresses'] as $address) {
                        if ($address == $transactions[0]->recipient) {
                            //change the amount of the tx and the type
                            $transactions[0]->amount = $payload['wallet']['balance'];
                            $transactions[0]->direction = "internal";
                            $transactions[0]->save();
                        }
                    }
                }
            }
        }

        return "webhook fired successfully";
    }

}
