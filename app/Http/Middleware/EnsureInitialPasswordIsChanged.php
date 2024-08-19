<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureInitialPasswordIsChanged
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  Closure(): void  $next
     */
    public function handle(Request $request, Closure $next): JsonResponse|Response
    {
        if (Auth::user()->initial_password_changed === false) {
            return new JsonResponse([
                'success' => false,
                'message' => __('additional.initial_password_must_be_changed'),
            ], Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
