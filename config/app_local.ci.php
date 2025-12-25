<?php

return [
	'debug' => filter_var(env('DEBUG', true), FILTER_VALIDATE_BOOLEAN),

	// Mercure configuration for CI tests
	'Mercure' => [
		'url' => 'http://localhost/.well-known/mercure',
		'public_url' => 'http://localhost/.well-known/mercure',
		'jwt' => [
			'secret' => 'test-secret-key-for-testing-only',
			'algorithm' => 'HS256',
			'publish' => ['*'],
			'subscribe' => ['*'],
		],
	],
];
