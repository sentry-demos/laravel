<?php

include 'inventory.php';
use App\Exceptions\Handler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;


/*
|--------------------------------------------------------------------------
| Web Routes
| The 'report' function in App/Exceptions/handler.php sends the error to Sentry
|--------------------------------------------------------------------------
*/


Auth::routes();

Route::get('/handled', function (Request $request) {
    try {
        throw new Exception("This is a handled exception");
    } catch (\Throwable $exception) {
        report($exception);
    }
    return $exception;
});

Route::get('/unhandled', function () {
    1/0;
});

Route::post('/checkout', function (Request $request) {
    $payload = $request->getContent();
    $order = json_decode($payload);
    $cart = $order->cart;

    try {
        process_order($order->cart);

    } catch (Exception $e) {
        report($e);
        return response("Internal Server Error", 500)->header("HTTP/1.1 500", "")->header('Content-Type', "text/html");
    }
});

function decrementInventory($item) {
    Cache::decrement($item->id, 1);
    error_log($item->id . " purchased");
}
function get_inventory() {
    $inventory = new StdClass();
    $inventory->wrench = Cache::get('wrench');
    $inventory->nails = Cache::get('nails');
    $inventory->hammer = Cache::get('hammer');
    return $inventory;
}
function isOutOfStock($item) {
    $inventory = get_inventory();
    return $inventory->{$item->id} <= 0;
}
function process_order(array $cart) {
    error_log("IN PROCESS ORDER");
    foreach ($cart as $item) {
        if (isOutOfStock($item)) {
            error_log("Not enough inventory for " . $item->id);
            throw new Exception("Not enough inventory for " . $item->id);
        } else {
            decrementInventory($item);
        }
    }
}

function set_inventory() {
    $tools = array(1 => "wrench", 2 => "nails", 3 => "hammer");
    foreach ($tools as &$tool) {
        if (!Cache::has($tool)) {
            Cache::increment($tool, 1);
        }
    }
}