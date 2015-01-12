<?php

class UserTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();

        //create a webhook user for authenticating webhook calls
        User::create(array('fname' => 'webhook', 'lname' => 'webhook', 'email' => 'webhook', 'password' => 'OxGKbaxYmvCumi'));
        //testing user
        User::create(array('fname' => 'joe', 'bloggs' => 'conolly', 'email' => 'test@test.com', 'password' => 'test'));
    }

}