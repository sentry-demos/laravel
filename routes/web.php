<?php

use App\Exceptions\Handler;
use Illuminate\Http\Request;
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

// error_log($request->json());
// error_log($request.post());
// both work
// error_log("1 "."2");
// error_log("1 ".$order);
Route::post('/checkout', ['middleware' => 'cors',function (Request $request) {
    error_log("11111");

    $order = $request->getContent();
    error_log($order);
    // error_log($order->email); // "Trying to get a property of a non-object"
    // error_log($order['email']); // "Illegal string offset 'email'"

    // $someJSON = json_encode($order);
    // error_log($someJSON->email); // "Trying to get a property of a non-object"
    // error_log($someJSON['email']); // "Illegal string offset 'email'"

    $myobj = json_decode($order);
    error_log($myobj->email);



    // error_log("Processing order for: ".$order->email);    
    // cart = order["cart"]
    // process_order(cart)


//     $someObject = ...; // Replace ... with your PHP Object
//   foreach($someObject as $key => $value) {
//     echo $value->name . ", " . $value->gender . "<br>";
//   }

    return 'successful';
    // return response('Hello World', 200)
    //               ->header('Access-Control-Allow-Origin', '*')
    //               ->header('Access-Control-Allow-Headers', 'Content-Type')
    //               ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
}]);