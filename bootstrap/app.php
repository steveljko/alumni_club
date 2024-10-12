<?php

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Lang;
use Illuminate\Foundation\Application;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
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
            'verify_password_change' => App\Http\Middleware\EnsureInitialPasswordIsChanged::class,
            'role' => App\Http\Middleware\CheckUserRole::class,
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
            ], Response::HTTP_UNAUTHORIZED);
        });

        // Change rendering output for NotFoundHttpException
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            // TODO: Find better way to implement this logic
            // BUG: If this if is removed, it will accur to all pages
            if (str_contains($request->path(), 'users')) {
                $methods = [
                    Request::METHOD_GET,
                    Request::METHOD_PUT,
                    Request::METHOD_PATCH,
                    Request::METHOD_DELETE,
                ];

                if (in_array($request->method(), $methods)) {
                    $params = explode('/', $request->path());

                    if (isset($params[1])) {
                        if (Lang::locale() == 'rs') {
                            $lang = trans('additional');
                            $model = $lang[$params[1]]['model_name'];
                        } else {
                            $model = ucfirst($params[1]);
                        }

                        $id = $params[2] ?? null;

                        return new JsonResponse([
                            'success' => false,
                            'message' => __('additional.model_not_found', [
                                'model' => $model,
                                'id' => $id,
                            ]),
                        ], Response::HTTP_NOT_FOUND);
                    }
                }
            }
        });
    })->create();
