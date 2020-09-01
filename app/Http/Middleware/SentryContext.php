<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;

class SentryContext
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (app()->bound('sentry')) {
            $sentry = app('sentry');

            // Add user context
            // if (auth()->check()) {
            //     $sentry->user_context(['email' => auth()->user()->email]);
            // } else {
            //     $sentry->user_context(['id' => null]);
            // }

            //$sentry->setUser(['email' => $request->header('']);


            $transaction_id = $request->header('X-Transaction-ID');

            // Setting tags
<<<<<<< Updated upstream
            $sentry->tags_context([
                'customerType' => 'enterprise',
                'transaction_id' => $transaction_id
            ]);
=======
            Sentry\configureScope(function (Sentry\State\Scope $scope): void {
                $scope->setExtra('customerType', 'enterprise');
                $scope->setExtra('transaction_id', $transaction_id);
              });
            // $sentry->setExtra([
            //     'customerType' => 'enterprise',
            //     'transaction_id' => $transaction_id
            // ]);

>>>>>>> Stashed changes
            // Set the inventory as Additional Information (Extra) on Sentry Event
            set_inventory();
            $inventory = array("inventory"=>json_encode(get_inventory()));
            $sentry->extra_context($inventory);

            $commitHash = trim(exec('git rev-parse HEAD'));
            $sentry->setRelease($commitHash);
        }

        return $next($request);
    }

    public function get_inventory() {
        $inventory = new StdClass();
        $inventory->wrench = Cache::get('wrench');
        $inventory->nails = Cache::get('nails');
        $inventory->hammer = Cache::get('hammer');
        return $inventory;
    }
    // cache is cleared when app is initialized by makefile
    public function set_inventory() {
        $tools = array(1 => "wrench", 2 => "nails", 3 => "hammer");
        foreach ($tools as &$tool) {
            if (!Cache::has($tool)) {
                Cache::increment($tool, 1);
            }
        }
    }
}
