<?php

class WebhookTableSeeder extends Seeder {

    public function run()
    {
        //don't clear table as remote webhooks have been created
        //DB::table('webhooks')->delete();

        $wallet = Wallet::first();
        if (App::environment('production')) {
            $url = URL::route('webhook', array('wallet_identity' => $wallet->identity));
        } else {
            //can't use http://localhost, must use a reachable URI. Use a ngrok to create a tunnel from a public domain to our local env (https://ngrok.com)
            $url = URL::route('webhook', array('wallet_identity' => $wallet->identity));
        }

        $newWebhook = new Webhook(array('identifier' => $wallet->identity, 'url' => $url, 'wallet_id' => $wallet->id));
        if(!$newWebhook->save()) {
            $errors = Session::get('webhook-error');
            echo "\n unable to create webhook: {$errors}\n";
        }
    }

}