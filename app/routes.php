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
Route::get('/', array('as' => 'home', 'uses' => 'ExplorerController@showHome'));
Route::get('/search', array('as' => 'search', 'uses' => 'ExplorerController@search'));
Route::get('/address/{address}', array('as' => 'address', 'uses' => 'ExplorerController@showAddress'));
Route::get('/block/{block}', array('as' => 'block', 'uses' => 'ExplorerController@showBlock'));
Route::get('/transaction/{transaction}', array('as' => 'transaction', 'uses' => 'ExplorerController@showTransaction'));
