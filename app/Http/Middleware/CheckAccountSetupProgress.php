<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAccountSetupProgress
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user) {
            if ($request->routeIs('auth.setup.step.1') && $user->isInitialPasswordChanged()) {
                return redirect()->route('auth.setup.step.2');
            }

            if ($user->areDetailsChanged()) {
                return redirect()->route('home');
            }
        }

        return $next($request);
    }
}
