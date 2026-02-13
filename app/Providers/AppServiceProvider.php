<?php

namespace App\Providers;

use App\Models\SocialLink;
use App\Models\SystemSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void {}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share system settings with all views
        View::composer('*', function ($view) {
            $systemSetting = SystemSetting::first(); // fetch the only record
            $socialLinks = SocialLink::where('status', 'active')->get(); // fetch the only record
            $view->with(['systemSetting' => $systemSetting, 'socialLinks' => $socialLinks]);
        });

        view()->composer('*', function ($view) {
            $user = Auth::user();
            $logoText = '<b>Admin</b>LTE';

            if ($user) {
                if ($user->role === 'student') {
                    $logoText = '<b>Student</b> Dashboard';
                } elseif ($user->role === 'teacher') {
                    $logoText = '<b>Teacher</b> Dashboard';
                } elseif ($user->role === 'super-admin') {
                    $logoText = '<b>Admin</b> Dashboard';
                }
            }

            config(['adminlte.logo' => $logoText]);
        });
    }
}
