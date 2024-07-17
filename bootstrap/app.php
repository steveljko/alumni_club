<?php

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\Permission\Exceptions\UnauthorizedException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->statefulApi();

        $middleware->alias([
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'verify_password_change' => \App\Http\Middleware\EnsureInitialPasswordIsChanged::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
      // Change rendering output for AuthenticationException
      $exceptions->render(function (AuthenticationException $e, Request $request) {
        return new JsonResponse([
          'success' => false,
          'message' => __('auth.unauthenticated'),
        ], Response::HTTP_UNAUTHORIZED);
      });

      // Change rendering output for UnauthorizedException
      $exceptions->render(function (UnauthorizedException $e, Request $request) {
        return new JsonResponse([
          'success' => false,
          'message' => __('auth.unauthorized'),
        ], Response::HTTP_FORBIDDEN);
      });
    })->create();
