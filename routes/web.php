<?php
include 'inventory.php';
use App\Exceptions\Handler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

/*
|--------------------------------------------------------------------------
| Web Routes
| The 'report' function in App/Exceptions/handler.php sends to Sentry
|--------------------------------------------------------------------------
*/


Auth::routes();

Route::get('/handled', function (Request $request) {
    try {
        thisFunctionFails();
    } catch (\Throwable $exception) {
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
    $order = json_decode($payload);
    $cart = $order->cart;

    process_order($order->cart);

    return 'success';
}]);

function decrementStock($item) {
    Cache::decrement($item->id, 1);
    error_log($item->id . " purchased");
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
    $tools = array(1 => "wrench", 2 => "nails", 3 => "hammer");
    foreach ($tools as &$tool) {
        if (!Cache::has($tool)) {
            Cache::increment($tool, 1);        
        }
    }
}
function process_order(array $cart) {
    foreach ($cart as $item) {
        if (isOutOfStock($item)) {
            error_log("Not enough stock for " . $item->id);
            report(new Exception("Not enough inventory for " . $item->id));
        } else {
            decrementStock($item);
        }
    }
}