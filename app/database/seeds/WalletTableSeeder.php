<?php

class WalletTableSeeder extends Seeder {

    public function run()
    {
        //don't clear table as remote wallets have been created
        //DB::table('wallets')->delete();

        $user = User::where('fname', 'joe')->first();
        $wallet = new Wallet(array('identity' => str_random(40), 'name' => 'my wallet', 'pass' => str_random(6), 'user_id' => $user->id));
        if(!$wallet->save()) {
            $errors = Session::get('wallet-error');
            echo "\n unable to create wallet: {$errors}\n";
        }
    }

}