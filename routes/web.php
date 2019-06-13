<?php
include 'inventory.php';
use App\Exceptions\Handler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * DEV NOTES
 * no global scope
 * can't persist state between http requests, so try putting Inventory in separate file (a separate process)
 * no objects with {} marks, though laravel's () is an option
 * associative array is alternative to an object, but will be harder to iterate through and use in process_order
 * can't get $global keyword to work according to https://www.php.net/manual/en/language.types.object.php
 */

// DEV NOTE    
// works, the variable comes from inventory.php
error_log(json_encode($inventory));

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
    global $inventory;
    // logs blank, but should be there according to https://www.php.net/manual/en/language.types.object.php ?
    error_log($inventory);

    $payload = $request->getContent();
    $order = json_decode($payload);
    error_log($order->email);
    process_order($order->cart, json_encode($inventory));

    // cart = order["cart"]

    return 'successful';

}]);