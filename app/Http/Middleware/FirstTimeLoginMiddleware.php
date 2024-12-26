<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FirstTimeLoginMiddleware
{
    /*
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user()->isInitialPasswordChanged() == true && $request->routeIs('auth.setup.initial_password_change')) {
            return redirect()->route('home');
        }

        if (auth()->user()->isInitialPasswordChanged() == false && $request->routeIs('home')) {
            return redirect()->route('auth.setup.initial_password_change');
        }

        return $next($request);
    }
}
