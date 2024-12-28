<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AccountSetupCompleted
{
    /**
     * Middleware to check if the user has completed the initial account setup.
     * If the user has not completed the setup, they will be redirected to the first setup step.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()->isSetupComplete()) {
            return redirect()->route('auth.setup.step.1');
        }

        return $next($request);
    }
}
