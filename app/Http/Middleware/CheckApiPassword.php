<?php

namespace App\Http\Middleware;

use Closure;

class CheckApiPassword
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
        if($request->api_password != env('API_PASSWORD','AhmedElkomy')){
            return response()->json(['message'=>'you cannot access Api']);
        }
        return $next($request);
    }
}
