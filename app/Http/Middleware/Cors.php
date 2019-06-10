<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Contracts\Routing\Middleware;
use Illuminate\Http\Response;

class Cors extends Middleware // extends Middleware?
{
    
    public function handle($request, Closure $next)
    {
        return $next($request)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    }
}