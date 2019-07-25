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
// =============================================================================
// GET
// =============================================================================
Route::get('fuel', [
    'uses' => 'FuelController@all',
]);
Route::get('fuel/last/', [
    'uses' => 'FuelController@last',
]);
// =============================================================================
// CUD
// =============================================================================
Route::post('fuel/create/', [
    'uses' => 'FuelController@createFuel',
]);
Route::post('fuel/update/', [
    'uses' => 'FuelController@updateFuel',
]);
// =============================================================================
// OTHER
// =============================================================================
Route::get('fuel/excel/{date}', [
    'uses' => 'FuelController@fuel',
]);