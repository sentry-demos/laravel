<?php

use App\Exceptions\Handler;
use Illuminate\Http\Request; // ?
use Illuminate\Http\Response;

// use Illuminate\Http\JsonResponse;
// use Illuminate\Support\Facades\Log;
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

Route::post('/checkout', ['middleware' => 'cors',function () {
    error_log("~~~~~~~~~~~~~~~~~~~~~~~~~~~~~");

    // order = json.loads(request.data)
    // print "Processing order for: " + order["email"]
    // cart = order["cart"]
    // process_order(cart)

    return 'Successfull';
    // return response('Hello World', 200)
    //               ->header('Access-Control-Allow-Origin', '*')
    //               ->header('Access-Control-Allow-Headers', 'Content-Type')
    //               ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
}]);