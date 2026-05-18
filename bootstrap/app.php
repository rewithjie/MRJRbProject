<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Apply global web middleware.
        $middleware->web(append: []);

        // Middleware group.
        $middleware->group('group', [
            \App\Http\Middleware\MiddlewareOne::class,
            \App\Http\Middleware\MiddlewareTwo::class,
        ]);

        // Route middleware aliases.
        $middleware->alias([
            'student.auth' => \App\Http\Middleware\StudentAuth::class,
            'teacher.auth' => \App\Http\Middleware\TeacherAuth::class,
            'admin.auth' => \App\Http\Middleware\AdminAuth::class,
            'no.cache' => \App\Http\Middleware\NoCache::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
