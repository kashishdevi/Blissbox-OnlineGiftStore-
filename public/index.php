<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Maintenance mode check
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Composer autoloader
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__.'/../bootstrap/app.php';

/** @var \Illuminate\Contracts\Http\Kernel $kernel */
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$request = Request::capture();

try {
    try {
        try {
            $response = $kernel->handle($request);
        } catch (Throwable $e) {
            // Show Laravel error page (if enabled), or show a simple error fallback
            if (app()->bound('env') && app()->environment('production')) {
                echo '<h2>Application Error</h2>';
                echo '<p>Something went wrong. Please try again later.</p>';
            } else {
                echo '<div style="background:#f8d7da;color:#721c24;border:1px solid #f5c6cb;padding:16px;margin:0;text-align:center;font-weight:600;">';
                echo '<h2>Application Error</h2>';
                echo '<pre style="white-space: pre-wrap; text-align:left;">' . htmlspecialchars($e->getMessage()) . "\n" . $e->getTraceAsString() . '</pre>';
                echo '</div>';
            }
            exit(1);
        }
    } catch (Exception $ex) {
        report($ex);
        throw $ex;
    }
} catch (Throwable $e) {
    // Show Laravel error page (if enabled), or show a simple error fallback
    if (app()->bound('env') && app()->environment('production')) {
        echo '<h2>Application Error</h2>';
        echo '<p>Something went wrong. Please try again later.</p>';
    } else {
        echo '<div style="background:#f8d7da;color:#721c24;border:1px solid #f5c6cb;padding:16px;margin:0;text-align:center;font-weight:600;">';
        echo '<h2>Application Error</h2>';
        echo '<pre style="white-space: pre-wrap; text-align:left;">' . htmlspecialchars($e->getMessage()) . "\n" . $e->getTraceAsString() . '</pre>';
        echo '</div>';
    }
    exit(1);
}

$response->send();
$kernel->terminate($request, $response);
