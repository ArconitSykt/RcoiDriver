<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Route::get('fuel/last/', [
    'uses' => 'FuelController@last',
]);

Route::post('fuel/create/', [
    'uses' => 'FuelController@create',
]);

Route::get('fuel/excel/{date}', [
    'uses' => 'FuelController@fuel',
]);