<?php

namespace App\Http\Middleware;

use Closure;

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
            /** @var \Raven_Client $sentry */
            $sentry = app('sentry');

            // Add user context
            if (auth()->check()) {
                $sentry->user_context(['email' => auth()->user()->email]);
            } else {
                $sentry->user_context(['id' => null]);
            }

            $transaction_id = $request->header('X-Transaction-ID');

            // Setting tags
            $sentry->tags_context([
                'customerType' => 'enterprise',
                'transaction_id' => $transaction_id
            ]);

            // Set what the current inventory is
            set_inventory();
            // $sentry->set_extra("inventory", read_inventory());

            $commitHash = trim(exec('git rev-parse HEAD'));
            $sentry->setRelease($commitHash);
        }

        return $next($request);
    }

    // public function read_inventory() {
    //     $inventory = new StdClass();
    //     $inventory->wrench = Cache::get('wrench');
    //     $inventory->nails = Cache::get('nails');
    //     $inventory->hammer = Cache::get('hammer');
    //     return $inventory;
    // }

    public function set_inventory() {
        $tools = array(1 => "wrench", 2 => "nails", 3 => "hammer");
        foreach ($tools as &$tool) {
            if (!Cache::has($tool)) {
                Cache::increment($tool, 1);        
            }
        }
    }
}
