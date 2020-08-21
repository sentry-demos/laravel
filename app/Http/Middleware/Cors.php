<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class Cors
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
        

            header("Access-Control-Allow-Origin: *");
    
            // ALLOW OPTIONS METHOD
            $headers = [
                'Access-Control-Allow-Methods'=> 'POST, GET, OPTIONS, PUT, DELETE',
                'Access-Control-Allow-Headers'=> 'Content-Type, X-Auth-Token, Origin, x-transaction-id'
            ];
            error_log("HI");
            error_log($request);
            error_log($request->getMethod());
            if($request->getMethod() == "OPTIONS") {
                error_log("ZAPP");
                // The client-side application can set only headers allowed in Access-Control-Allow-Headers
                return Response::make(500, $headers);
            }
    
            $response = $next($request);
            foreach($headers as $key => $value)
                $response->header($key, $value);
            return $response;
        
 
        // error_log("GOT TO HANDLE");
        // error_log($request);
        // if ($request->Access-Control-Request-Method:'POST'){
        //     $response = Response::make();
        //     error_log("ZAPPER");
        // } else {
        //     $response = $next($request);
        // }
        // // return $next($request)
        // return $response
        //     ->header('Access-Control-Allow-Origin', '*')
        //     ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
        //     ->header('Access-Control-Allow-Headers', '*');

        //create a react project, create a backend project GCP
        //label accordingly
    }
}

