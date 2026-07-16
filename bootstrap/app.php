<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

/*
|--------------------------------------------------------------------------
| Force-resolve DB_CONNECTION from .env
|--------------------------------------------------------------------------
| Pada beberapa environment shell, variabel DB_CONNECTION bisa ter-set
| di level sistem (mis. 'sqlite') dan meng-override nilai di file .env.
| Karena project ini menargetkan MySQL, kita pastikan nilai dari .env
| diutamakan agar konfigurasi database selalu konsisten.
*/
$envFile = dirname(__DIR__) . '/.env';
if (is_file($envFile) && !getenv('APP_FORCE_RAW_ENV')) {
    foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        if (str_starts_with(trim($line), '#')) {
            continue;
        }
        if (!str_contains($line, '=')) {
            continue;
        }
        [$key, $value] = array_map('trim', explode('=', $line, 2));
        $value = trim($value, '"\'');
        if (in_array($key, ['DB_CONNECTION', 'DB_HOST', 'DB_PORT', 'DB_DATABASE', 'DB_USERNAME', 'DB_PASSWORD'], true)) {
            putenv("{$key}={$value}");
            $_ENV[$key] = $value;
        }
    }
}

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => \App\Http\Middleware\EnsureUserIsAdmin::class,
            'jamaah' => \App\Http\Middleware\EnsureUserIsJamaah::class,
            'visitor' => \App\Http\Middleware\TrackVisitor::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

