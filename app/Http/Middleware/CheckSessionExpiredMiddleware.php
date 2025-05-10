<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckSessionExpiredMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && session()->has('login_timestamp')) {
            if (now()->diffInMinutes(session('login_timestamp')) > config('session.lifetime')) {
                Auth::logout();
                session()->forget('login_timestamp');

                session(['session_expired' => true]);

                return redirect('/login');
            }
        }

        session(['login_timestamp' => now()]);

        return $next($request);
    }
}
