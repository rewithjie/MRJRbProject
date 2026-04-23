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


    //middleware group
    $middleware->group('group',[
        \App\Http\Middleware\MiddlewareOne::class,
        \App\Http\Middleware\MiddlewareTwo::class,
        \App\Http\Middleware\DownForMaintnanceMW::class
        ]);

        //route middleware
    $middleware->alias([
        'maintenance' => \App\Http\Middleware\DownForMaintnanceMW::class,
        'student.auth' => \App\Http\Middleware\StudentAuth::class
    ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
