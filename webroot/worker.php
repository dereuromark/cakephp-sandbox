<?php
/**
 * FrankenPHP Worker Mode Entry Point
 *
 * This script keeps CakePHP bootstrapped in memory and handles
 * requests in a loop for better performance.
 *
 * @see https://frankenphp.dev/docs/worker/
 */

// Mark that we're running in worker mode
// Create a marker file that persists for the lifetime of this worker
$workerMarkerFile = sys_get_temp_dir() . '/frankenphp_worker_' . getmypid();
file_put_contents($workerMarkerFile, '1');
register_shutdown_function(function() use ($workerMarkerFile) {
    @unlink($workerMarkerFile);
});

// Check platform requirements
require dirname(__DIR__) . '/config/requirements.php';

// Autoload
require dirname(__DIR__) . '/vendor/autoload.php';

use App\Application;
use Cake\Http\Server;

// Create application and server instance once (kept in memory)
$app = new Application(dirname(__DIR__) . '/config');
$server = new Server($app);

// Max requests before worker restarts (prevents memory leaks)
$maxRequests = (int)($_SERVER['MAX_REQUESTS'] ?? 500);

// Handle requests in a loop
for ($requestCount = 0; $requestCount < $maxRequests; $requestCount++) {
    $running = frankenphp_handle_request(function () use ($server): void {
        try {
            $server->emit($server->run());
        } catch (Throwable $e) {
            error_log('Worker error: ' . $e->getMessage());
        }
    });

    if (!$running) {
        break;
    }

    // Garbage collection between requests
    gc_collect_cycles();
}
