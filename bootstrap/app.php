<?php

use App\Http\Middleware\AdminRoleMiddleware;
use App\Http\Middleware\LogApiRequest;
use App\Http\Middleware\SystemCommandAuth;
use App\Models\Repair;
use App\Observers\RepairObserver;
use App\Providers\QueryLogServiceProvider;
use App\Providers\RateLimitServiceProvider;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Middleware\HandleCors;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('web')
                ->prefix('admin')
                ->name('admin.')
                ->group(base_path('routes/admin.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->prepend(HandleCors::class);
        $middleware->alias([
            'role' => AdminRoleMiddleware::class,

        ]);

        $middleware->appendToGroup('api', [

        ]);
    })
    ->withProviders([

    ])

    ->withProviders([

    ])
    ->booted(function () {
    })
    ->withExceptions(function (Exceptions $exceptions) {

    })

    ->create();
