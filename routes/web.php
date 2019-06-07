<?php

use App\Exceptions\Handler;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout' );

Route::get('/handled', function () {
    try {
        thisFunctionFails();
    } catch (\Throwable $exception) {
        // Sentry Event is sent by 'report' function in Handler.php
        report($exception);
    }
    // echo $exception
    // return "see Sentry.io";
    return $exception;
});
Route::get('/unhandled', function () {
    1/0;
});
Route::post('/checkout', function () {
    // TODO produce the /checkout logic in PHP
});