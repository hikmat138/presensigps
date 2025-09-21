<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle($request, Closure $next, ...$guards)
    {
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                if ($guard === 'user') {
                    return redirect()->route('/panel/dashboardadmin');
                } elseif ($guard === 'pegawai') {
                    return redirect()->route('/dashboard');
                }
            }
        }

        return $next($request);
    }
}
