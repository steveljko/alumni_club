<?php

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Lang;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

      // Change rendering output for NotFoundHttpException
      $exceptions->render(function (NotFoundHttpException $e, Request $request) {
        $methods = [Request::METHOD_PUT, Request::METHOD_PATCH];

        if (in_array($request->method(), $methods)) {
          $params = explode('/', $request->path());

          if (isset($params[1])) {
            $model = ucfirst($params[1]);

            // TODO: Find better way to translate model names to Serbian language.
            if (Lang::locale() == 'rs' && $model == 'Jobs') {
              $model = 'Posao';
            }

            $id = $params[2] ?? null;

            return new JsonResponse([
              'success' => false,
              'message' => __('additional.model_not_found', [
                'model' => $model,
                'id' => $id
              ]),
            ], Response::HTTP_NOT_FOUND);
          }
        }
      });
    })->create();
