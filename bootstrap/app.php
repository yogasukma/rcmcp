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
        // Add CORS middleware globally
        $middleware->append(\App\Http\Middleware\CorsMiddleware::class);

        // Add MCP authentication middleware alias
        $middleware->alias([
            'mcp.auth' => \App\Http\Middleware\McpAuthMiddleware::class,
            'extract.runcloud.token' => \App\Http\Middleware\ExtractRunCloudToken::class,
        ]);

        // Note: Redis throttling removed for SQLite compatibility
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
