<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Route;
use Closure;
use Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */

    public function handle($request, Closure $next, ...$guards)
    {
        $this->guards = $guards;

        return parent::handle($request, $next, ...$guards);
    }


    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            // to redirect admin/login when route is admin
            if (Route::is('admin.*')) {
                return route('admin.login');
            }
            return route('login');
        }
    }
}
