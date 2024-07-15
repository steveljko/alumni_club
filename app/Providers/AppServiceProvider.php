<?php

namespace App\Providers;

use Knuckles\Camel\Extraction\ExtractedEndpointData;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;
use Laravel\Sanctum\Sanctum;
use Knuckles\Scribe\Scribe;
use App\Models\User;

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
  public function boot(): void
  {
    //
  }
}
