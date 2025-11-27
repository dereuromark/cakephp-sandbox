<?php
declare(strict_types=1);

namespace App\Http\Middleware;

use Cake\Http\Middleware\RateLimitMiddleware;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Demo Rate Limit Middleware - CakePHP 5.3 Feature
 *
 * Demonstrates the new RateLimitMiddleware for API rate limiting.
 * Limits requests to 10 per minute per IP address.
 */
class DemoRateLimitMiddleware extends RateLimitMiddleware {

	public function __construct() {
		// Limit to 5 requests per minute
		parent::__construct([
			'limit' => 5,
			'window' => 60, // 60 seconds = 1 minute
			'identifier' => 'ip', // Identify by IP address
			'strategy' => 'fixed_window', // Use fixed_window for more predictable behavior
			'headers' => true, // Add X-RateLimit-* headers
			'message' => 'Too many requests. Please try again in a minute.',
			// Only apply rate limiting to the rate limit demo page
			'skipCheck' => function (ServerRequestInterface $request) {
				/** @var array<string, mixed> $params */
				$params = $request->getAttribute('params', []);

				// Only apply rate limiting to Sandbox.CakeExamples::rateLimiter
				return !($params['plugin'] === 'Sandbox'
					&& $params['controller'] === 'CakeExamples'
					&& $params['action'] === 'rateLimiter');
			},
		]);
	}

}
