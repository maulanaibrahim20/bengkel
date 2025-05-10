<?php

use App\Http\Middleware\CheckSessionExpiredMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->redirectUsersTo(function (Request $request) {
            if (! $request->user()) {
                return '/login';
            }

            $roleId = $request->user()->role_id;

            if ($roleId == 1) {
                return '/super-admin/dashboard';
            } elseif ($roleId == 2) {
                return '/admin/dashboard';
            } elseif ($roleId == 3) {
                return '/user/dashboard';
            } else {
                return '/home';
            }
        });
        $middleware->web(append: [CheckSessionExpiredMiddleware::class]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
