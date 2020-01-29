<?php

namespace App\Http\Middleware;

use Closure;

class HttpHeaders
{
    /**
     * Handle an incoming request function.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $response->header('X-JOBS','COME WORK WITH US');
         return $response;
    }
}
