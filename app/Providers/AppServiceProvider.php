<?php

namespace App\Providers;
use App\Models\SystemSetting;
use Illuminate\Support\Facades\View;
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
    public function boot(): void
    {
        // Share system settings with all views
        View::composer('*', function ($view) {
            $systemSetting = SystemSetting::first(); // fetch the only record
            $view->with('systemSetting', $systemSetting);
        });
    }
}
