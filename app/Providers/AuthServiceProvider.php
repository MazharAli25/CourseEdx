<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        Gate::define('super-admin', fn ($user) => $user->role === 'super-admin');
        Gate::define('teacher', fn ($user) => $user->role === 'teacher');
        Gate::define('student', fn ($user) => $user->role === 'student');

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
