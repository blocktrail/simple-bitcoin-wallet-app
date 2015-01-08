<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

/*---Block Explorer---*/
Route::group(['prefix' => 'explorer'], function($router) {
    Route::get('/', array('as' => 'explorer', 'uses' => 'ExplorerController@showHome'));
    Route::get('/search', array('as' => 'search', 'uses' => 'ExplorerController@search'));
    Route::get('/address/{address}', array('as' => 'address', 'uses' => 'ExplorerController@showAddress'));
    Route::get('/block/{block}', array('as' => 'block', 'uses' => 'ExplorerController@showBlock'));
    Route::get('/transaction/{transaction}', array('as' => 'transaction', 'uses' => 'ExplorerController@showTransaction'));
});

/*---Authentication---*/
Route::get('/login', array('as' => 'login', 'uses' => 'AuthController@showLogin'));
Route::post('/login', array('as' => 'login', 'uses' => 'AuthController@authenticate'));
Route::get('/logout', array('as' => 'logout', 'uses' => 'AuthController@logout'));

/*-- Dashboard Section --*/
Route::group(['before' => 'auth'], function($router){
    //Model bindings
    Route::model('wallet', 'Wallet');

    Route::get('/dashboard', array('as' => 'dashboard', 'uses' => 'HomeController@showDashboard'));

    //wallet routes
    Route::get('/wallet/new', array('as' => 'wallet.create', 'uses' => 'WalletController@showNewWallet'));
    Route::post('/wallet/new', array('as' => 'wallet.create', 'uses' => 'WalletController@createNewWallet'));
    Route::get('/wallet/{wallet}', array('as' => 'wallet.edit', 'uses' => 'WalletController@showWallet'));
    Route::post('/wallet/{wallet}', array('as' => 'wallet.edit', 'uses' => 'WalletController@updateWallet'));
    Route::get('/wallet/{wallet}/send', array('as' => 'wallet.send', 'uses' => 'WalletController@showSendPayment'));
    Route::post('/wallet/{wallet}/send', array('as' => 'wallet.send', 'uses' => 'WalletController@sendPayment'));
    Route::get('/wallet/{wallet}/receive', array('as' => 'wallet.receive', 'uses' => 'WalletController@showReceivePayment'));
});

/*---Webhooks---*/
Route::group(['before' => 'auth.basic'], function($router){
    Route::get('/webhook/{wallet_identity}', array('as' => 'webhook', 'uses' => 'WebhookController@webhookCalled'));
});


Route::get('test', function(){
    return URL::route('webhook');
});