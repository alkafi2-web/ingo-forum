<?php

use App\Http\Middleware\adminMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => adminMiddleware::class,
            'auth.member' => \App\Http\Middleware\MemberMiddleware::class,
            'adminOrMember' => \App\Http\Middleware\AdminOrMember::class,
            'updateLastActivity' => \App\Http\Middleware\UpdateLastActivity::class,
            'trackvisitor' => \App\Http\Middleware\TrackVisitor::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
