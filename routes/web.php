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
// error_log(json_encode($inventory));


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

function check_cache() {
    if (!Cache::has('wrench')) {
        Cache::increment('wrench', 1);        
    }
    if (!Cache::has('nails')) {
        Cache::increment('nails', 1);
    }
    if (!Cache::has('hammer')) {
        Cache::increment('hammer', 1);
    }
}

class Inventory {
    var $wrench;
    var $nails;
    var $hammer;
    public function __construct() 
    {
        $this->wrench = Cache::get('wrench');
        $this->nails = Cache::get('nails');
        $this->hammer = Cache::get('hammer');
    }

    public function getItem($item) {
        error_log("getting item..." . $item);
        return $this->$item;
    }

    public function decrement($item) {
        $this->$item = $this->$item - 1; // -= 1;
    }

}

function process_order(array $cart) {
    $Inventory = new Inventory();
    error_log("Inventory" . json_encode($Inventory));

    $tempInventory = $Inventory;
    error_log("tempInventory" . json_encode($tempInventory));

    foreach ($cart as $item) {
        error_log("cart item " . json_encode($item));

        error_log("GGGGG " . $Inventory->getItem("nails"));

        if ($Inventory->getItem($item->id) <= 0) {
            error_log("FAILURE no Inventory");
        } else {
            $tempInventory->decrement($item); // -=1;
            error_log("SUCCESS"); // error_log("Success: " . $item["id"] . " was purchased, remaining stock is " . str($tempInventory[$item["id"]])
        }
    }
    $Inventory = $tempInventory;
}

// TODO - tag scope, email, inventory, cart, other? see Flask demo
Route::post('/checkout', ['middleware' => 'cors',function (Request $request) {
    check_cache();

    // TODO - remove
    // $value = Cache::get('wrench');
    // error_log('1111111 ' . $value);
    // Cache::increment('wrench', 1);


    $payload = $request->getContent();
    $order = json_decode($payload);
    error_log($order->email);

    process_order($order->cart);
    // cart = order["cart"]

    return 'successful';

}]);