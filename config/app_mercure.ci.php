<?php

/**
 * Mercure Plugin Configuration for CI Tests
 *
 * This file is copied to app_mercure.php during CI runs to override
 * the Mercure plugin's default configuration.
 */

return [
	'Mercure' => [
		'url' => 'http://localhost/.well-known/mercure',
		'public_url' => 'http://localhost/.well-known/mercure',
		'jwt' => [
			'secret' => 'test-secret-key-for-ci-testing-only',
			'algorithm' => 'HS256',
			'publish' => ['*'],
			'subscribe' => ['*'],
		],
	],
];
