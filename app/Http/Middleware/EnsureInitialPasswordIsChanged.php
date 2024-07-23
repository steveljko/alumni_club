<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
    if ($request->user()->initial_password_changed === false) {
      return new JsonResponse([
        'success' => false,
        'message' => __('additional.initial_password_must_be_changed'),
      ], Response::HTTP_FORBIDDEN);
    }

    return $next($request);
  }
}
