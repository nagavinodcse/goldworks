<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminAuth
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
        $user = $request->user();
        if($user->role !== "ADMIN"):
            Auth::logout();
            $request->session()->flush();
            $request->session()->regenerate();
            return redirect('/login');
        endif;
        return $next($request);
    }
}
