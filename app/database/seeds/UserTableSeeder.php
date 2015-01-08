<?php

class UserTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();

        //create a webhook user for authenticating webhook calls
        User::create(array('fname' => 'webhook', 'lname' => 'webhook', 'email' => 'webhook@oacdesigns.com', 'password' => 'OxGKbaxYmvCumi'));
        //testing user
        User::create(array('fname' => 'oisin', 'lname' => 'conolly', 'email' => 'oisin@oacdesigns.com', 'password' => 'test'));
    }

}