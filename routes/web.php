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
    return view('home');
});

Route::get('/undefined_variable', function () {
    $x = $abc;
});

Route::get('/divbyzero', function () {
    1/0; // simulated error
});

Route::get('/badinclude', function () {
    include('invalidfile');
});

Route::get('/outofrange', function () {
    $cars = array("0", "1")[2];
});

Route::get('/invalidfunction', function () {
    invalidFunction();
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout' );

Route::post('/checkout', function () {
    // TODO produce the /checkout logic in PHP
});