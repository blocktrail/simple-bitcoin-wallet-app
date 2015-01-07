<?php

class WalletTableSeeder extends Seeder {

    public function run()
    {
        DB::table('wallets')->delete();

        //Wallet::create(array('fname' => 'oisin', 'lname' => 'conolly', 'email' => 'oisin@oacdesigns.com', 'password' => 'test'));
    }

}