<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Route;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class CheckUserMustLoggedIn
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

        if (!$isLogin) {
            return redirect(url('auth/login'));
        }

        $user   = Auth::guard('web')->user();
        if ($user AND is_null($user->activated)) {
            //alertNotify(false,'Harap verifikasi nomor handphone Anda terlebih dahulu', $request);
            //return redirect(url('auth/resend-verification-process'));
        }

        return $next($request);
    }
}
