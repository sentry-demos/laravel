<?php
include 'inventory.php';
use App\Exceptions\Handler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/


Auth::routes();

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

// TODO - tag scope, email, inventory, cart, other? see Flask demo
Route::post('/checkout', ['middleware' => 'cors',function (Request $request) {
    load_cache();
    $payload = $request->getContent();
    
    $hammers = Cache::get('hammer');
    error_log('HAMMERS IN STOCK ~~~~~~ ' . $hammers);

    $order = json_decode($payload);
    $cart = $order->cart;

    process_order($order->cart);

    return 'successful';

}]);

function decrementStock($item) {
    Cache::decrement($item->id, 1);
    error_log("SUCCESS");
}
function getInventory() {
    $inventory = new StdClass();
    $inventory->wrench = Cache::get('wrench');
    $inventory->nails = Cache::get('nails');
    $inventory->hammer = Cache::get('hammer');
    return $inventory;
}
function isOutOfStock($item) {
    $inventory = getInventory();
    return $inventory->{$item->id} <= 0;
}
function load_cache() {
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
function process_order(array $cart) {
    foreach ($cart as $item) {
        error_log("cart item " . json_encode($item));

        if (isOutOfStock($item)) {
             error_log("FAILURE no Inventory");
        } else {
            decrementStock($item);
        }
    }
}