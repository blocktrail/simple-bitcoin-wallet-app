<?php

class UserTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();

        //testing user
        User::create(array('fname' => 'joe', 'lname' => 'bloggs', 'email' => 'test@test.com', 'password' => 'test'));

        //create a webhook user for authenticating webhook calls
        User::create(array('fname' => 'webhook', 'lname' => 'webhook', 'email' => 'webhook', 'password' => 'OxGKbaxYmvCumi'));
    }

}