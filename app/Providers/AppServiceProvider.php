<?php

namespace App\Providers;

use App\Http\Middleware\ModifyDuskBrowserTime;
use App\Models\WorkHistory;
use App\Policies\WorkHistoryPolicy;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Gate;
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
    }
}
