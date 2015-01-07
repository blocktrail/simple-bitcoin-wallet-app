<?php

class WalletTableSeeder extends Seeder {

    public function run()
    {
        //don't clear table as remote wallets have been created
        //DB::table('wallets')->delete();

        $user = User::first();
        Wallet::create(array('identity' => str_random(40), 'pass' => str_random(6), 'user_id' => $user->id));
    }

}