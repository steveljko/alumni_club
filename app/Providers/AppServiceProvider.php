<?php

namespace App\Providers;

use App\Http\Middleware\ModifyDuskBrowserTime;
use App\Models\Setting;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
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

        if (Schema::hasTable('settings')) {
            $settings = Cache::rememberForever('settings', function () {
                return Setting::all()->pluck('value', 'key')->toArray();
            });

            config(['settings' => $settings]);
        }
    }
}
