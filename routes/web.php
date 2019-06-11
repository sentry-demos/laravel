<?php

use App\Exceptions\Handler;
use Illuminate\Http\Request; // ?
use Illuminate\Http\Response;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Headers: Content-Type");


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout' );

Route::get('/handled', function (Request $request) {
    echo $request;
    echo '\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n';
    try {
        thisFunctionFails();
    } catch (\Throwable $exception) {
        // Sentry Event is sent by 'report' function in Handler.php
        report($exception);
    }
    return $exception;
});

Route::get('/unhandled', function () {
    // 1/0;
    return 'unhandled success';
    // return response('Hello World', 200)
    // ->header('Access-Control-Allow-Origin', '*')
    // ->header('Access-Control-Allow-Headers', 'Content-Type')
    // ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');

});

/**
 * Need CSRF token?
 * https://stackoverflow.com/questions/30756682/laravel-x-csrf-token-mismatch-with-postman
 * 
 * https://stackoverflow.com/questions/35137768/how-to-use-postman-for-laravel-post-request/35141336
 * excluding csrf requirement https://laravel.com/docs/5.1/routing#csrf-excluding-uris
 */
Route::post('/checkout', ['middleware' => 'cors',function () {
    echo '\n~~~~~~~~~~~~~~~~~~~~~~~~~~ checkout ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n';

// Route::post('/checkout', ['middleware' => 'cors',function () {
    // header("Access-Control-Allow-Origin: *");
    // header("Access-Control-Allow-Headers: Content-Type");

    // TODO produce the /checkout logic in PHP
    // echo 'checkout...';

    // order = json.loads(request.data)
    // print "Processing order for: " + order["email"]
    // cart = order["cart"]
    
    // process_order(cart)

    return 'Successfull';
    // return response('Hello World', 200)
                //   ->header('Access-Control-Allow-Origin', '*');
    //               ->header('Access-Control-Allow-Headers', 'Content-Type')
    //               ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');

}]);
// })->middleware('cors');