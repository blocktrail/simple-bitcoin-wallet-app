<?php

class UserTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();

        User::create(array('fname' => 'oisin', 'lname' => 'conolly', 'email' => 'oisin@oacdesigns.com', 'password' => 'test'));
    }

}