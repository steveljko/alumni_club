<?php

namespace App\Providers;

use App\Http\Middleware\ModifyDuskBrowserTime;
use App\Models\WorkHistory;
use App\Policies\WorkHistoryPolicy;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(Router $router): void
    {
        if (app()->environment(['testing', 'local'])) {
            $router->prependMiddlewareToGroup('web', ModifyDuskBrowserTime::class);
        }

        Gate::policy(WorkHistory::class, WorkHistoryPolicy::class);

        Validator::extend('base64_image_size', function ($attribute, $value, $parameters, $validator) {
            $decodedImage = base64_decode($value);
            $size = strlen($decodedImage) / 1024;

            return $size <= $parameters[0];
        });

        Validator::extend('base64_image_size', function ($attribute, $value, $parameters, $validator) {
            $decodedImage = base64_decode($value);
            $size = strlen($decodedImage) / 1024;

            return $size <= $parameters[0];
        });

        Validator::extend('base64_image_type', function ($attribute, $value, $parameters, $validator) {
            if (preg_match('/^data:image\/(\w+);base64,/', $value, $type)) {
                $fileType = $type[1];

                return in_array($fileType, $parameters);
            }

            return false;
        });
    }
}
