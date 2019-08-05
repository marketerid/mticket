<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Route;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class CheckUserLoggedIn
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

        $isLogin = false;
        try{
            $isLogin = Auth::guard('web')->check();
        }catch (\Exception $e){

        }

        if ($isLogin) {
            return redirect(url('dashboard'));
        }

        return $next($request);
    }
}
