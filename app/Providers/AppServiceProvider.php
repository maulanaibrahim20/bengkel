<?php

namespace App\Providers;

use App\Models\Roles;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
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
    public function boot(): void
    {
        Gate::define('super-admin', function ($user) {
            return !empty($user->role) && $user->role->id == Roles::SUPER_ADMIN;
        });

        Gate::define('admin', function ($user) {
            return !empty($user->role) && $user->role->id == Roles::ADMIN;
        });

        Gate::define('user', function ($user) {
            return !empty($user->role) && $user->role->id == Roles::USER;
        });

        View::composer('*', function ($view) {
            $segments = Request::segments();
            $lastSegment = end($segments);

            $title = ucwords(str_replace('-', ' ', $lastSegment));

            $view->with('pageTitle', $title ?: 'Default Title');
        });
    }
}
