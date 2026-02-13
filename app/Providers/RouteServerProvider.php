<?php

namespace App\Providers;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class RouteServerProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        Route::bind('slider_image', function ($value) {
            return Crypt::decrypt($value);
        });
        Route::bind('social_link', function ($value) {
            return Crypt::decrypt($value);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
