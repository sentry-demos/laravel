<?php
include 'inventory.php';
use App\Exceptions\Handler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\Cache;

/**
 * DEV NOTES
 * no global scope
 * can't persist state between http requests
 * I put Inventory in separate file (a separate process) and web.php can access it, but not form within the api route
 * no objects with {} marks, though laravel's () is an option
 * associative array is alternative to an object, but will be harder to iterate through and use in process_order
 * can't get $global keyword to work according to https://www.php.net/manual/en/language.types.object.php
 * idea - create a Factory that doesn't touch a real DB but returns dummy data? synchronously
 * idea - try using 'config' modules in Laravel, but are these immutable?
 * idea - is there a way to reference inventory.php from within the /checkout route?
 * idea - laravel's Cache fake database...?
 */

// DEV NOTE    
// works, the variable comes from inventory.php
error_log(json_encode($inventory));

// Cache::pull('wrench');
// Cache::flush();
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/


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
    1/0;
});

function process_order(array $cart) {
    global $inventory;

    // logs blank
    error_log(json_encode($inventory));

    global $inventory;
    error_log($inventory);
    $tempInventory = $inventory;

    error_log($tempInventory);
    foreach ($cart as $item) {
        // error_log(json_encode($item));
        // error_log(serialize($item)); // O:8:"stdClass":4:{s:2:"id";s:6:"hammer";s:4:"name";s:6:"Hammer";s:5:"price";i:1000;s:3:"img";s:33:"/static/media/hammer.9b816abf.png";}

        if ($Inventory[$item['id']] <= 0) {
            // raise exception...
        } else {
            $tempInventory[$item['id']] -= 1;
            // php for: print 'Success: ' + item['id'] + ' was purchased, remaining stock is ' + str(tempInventory[item['id']])
        }
    }
    $Inventory = $tempInventory;
}

Route::post('/checkout', ['middleware' => 'cors',function (Request $request) {

    $value = Cache::get('wrench', 1);
    error_log('11111111');
    // $v1 = "my value";
    // error_log("value is " . $v1); // TODO
    error_log($value);
    error_log('222222');

    Cache::increment('wrench', 1);



    global $inventory;
    // logs blank, but should be there according to https://www.php.net/manual/en/language.types.object.php ?
    // error_log($inventory);

    $payload = $request->getContent();
    $order = json_decode($payload);
    error_log($order->email);
    // process_order($order->cart, json_encode($inventory));

    // cart = order["cart"]

    return 'successful';

}]);