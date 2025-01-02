<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CanAccessSetupStep
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $step): Response
    {
        $userStep = $request->user()->setup_progress;

        if ($userStep == 'completed') {
            return redirect()->route('home');
        }

        $routeStep = "step.$step";

        if ($userStep != $routeStep) {
            return redirect()->route("auth.setup.{$userStep}");
        }

        return $next($request);
    }
}
