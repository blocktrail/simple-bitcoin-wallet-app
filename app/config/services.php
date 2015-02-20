<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => array(
        'domain' => $_ENV['MAILGUN_DOMAIN'],
        'secret' => $_ENV['MAILGUN_SECRET'],
    ),

    'mandrill' => array(
        'secret' => '',
    ),

    'stripe' => array(
        'model'  => 'User',
        'secret' => '',
    ),


    'blocktrail' => array(
        'key'      => $_ENV['BLOCKTRAIL_KEY'],
        'secret'   => $_ENV['BLOCKTRAIL_SECRET'],
        'currency' => 'btc',
        'testnet'  => $_ENV['ENABLE_TESTNET'],  //use the testnet
        'disable_ssl' => false,                 //disable ssl verification, only for local testing
    ),

);
