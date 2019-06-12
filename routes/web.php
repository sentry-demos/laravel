<?php

use App\Exceptions\Handler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

// use Monolog\Logger;
// use Monolog\Handler\StreamHandler;
// // create a log channel
// $log = new Logger('name');
// $log->pushHandler(new StreamHandler('path/to/your.log', Logger::WARNING));
//     $log->warning('Foo');
//     $log->error('Bar');

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

function process_order(array $cart) {
    // print_r("CART...");
    error_log("Cart...size".sizeof($cart));

    foreach ($cart as $val) {
        error_log("Cart...iterate...");
        error_log(json_encode($val));
        error_log(serialize($val));

        // error_log("$key => $val");
        // echo "$key => $val \n";
    }
}

Route::post('/checkout', ['middleware' => 'cors',function (Request $request) {

    $payload = $request->getContent();
    $order = json_decode($payload);
    error_log($order->email);
    process_order($order->cart);


    // cart = order["cart"]

    return 'successful';
    // return response('Hello World', 200)
    //               ->header('Access-Control-Allow-Origin', '*')
    //               ->header('Access-Control-Allow-Headers', 'Content-Type')
    //               ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
}]);