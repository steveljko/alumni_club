<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class ModifyDuskBrowserTime
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Cookie::has('dusk-skip-time')) {
            $time = Cookie::get('dusk-skip-time');
            $parsed = Carbon::parse($time);

            if ($parsed->isValid()) {
                Carbon::setTestNow($parsed->toIso8601String());
            }
        }

        return $next($request);
    }
}
