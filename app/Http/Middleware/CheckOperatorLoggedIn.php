<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Route;

class CheckOperatorLoggedIn
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
            $isLogin = Auth::guard('operator')->check();
        }catch (\Exception $e){

        }

        if (!$isLogin) {
            return redirect(url('auth/login-op'));
        }

        $user   = Auth::guard('operator')->user();

        return $next($request);
    }
}
