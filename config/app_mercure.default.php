<?php

use Cake\Http\Cookie\CookieInterface;

/**
 * Mercure Plugin Configuration for Sandbox
 *
 * Copy this file to app_mercure.php and set your JWT secret.
 *
 * For ddev with FrankenPHP: Mercure is built-in, configured via
 * .ddev/docker-compose.mercure.yaml
 *
 * For devilbox/standalone: Run Mercure hub separately:
 *   docker run -d --name mercure-sandbox \
 *     -e SERVER_NAME=:3080 \
 *     -e MERCURE_PUBLISHER_JWT_KEY='your-secret-here' \
 *     -e MERCURE_SUBSCRIBER_JWT_KEY='your-secret-here' \
 *     -e MERCURE_CORS_ALLOWED_ORIGINS='*' \
 *     -p 3080:3080 dunglas/mercure
 */

// Detect ddev environment
$isDdev = (bool)getenv('DDEV_PROJECT');

if ($isDdev) {
	// ddev with FrankenPHP - Mercure is on same host
	// Internal URL for server-side publishing (inside container)
	$mercureUrl = 'http://localhost/.well-known/mercure';
	// External URL for browser EventSource connections
	$mercurePublicUrl = getenv('DDEV_PRIMARY_URL') . '/.well-known/mercure';
} else {
	// Standalone/devilbox - separate Mercure container
	$mercureUrl = 'http://localhost:3080/.well-known/mercure';
	$mercurePublicUrl = $mercureUrl;
}

return [
	'Mercure' => [
		// Server-side URL for publishing
		'url' => $mercureUrl,

		// Client-side URL for EventSource connections
		'public_url' => $mercurePublicUrl,

		'jwt' => [
			// Must match the secret in ddev config or Docker container
			'secret' => 'your-secret-key-here',
			'algorithm' => 'HS256',
			'publish' => ['*'],
			'subscribe' => [],
		],

		'cookie' => [
			'name' => 'mercureAuthorization',
			'secure' => $isDdev, // true for ddev (HTTPS), false for devilbox
			'httponly' => true,
			'samesite' => CookieInterface::SAMESITE_LAX,
		],
	],
];
