<?php

return [
	'debug' => filter_var(env('DEBUG', true), FILTER_VALIDATE_BOOLEAN),

	'Security' => [
		'salt' => '9ebcb009bb3f8ebe43a4addc3fc1c1f310c50520',
	],

	'Datasources' => [
		'default' => [
			'password' => env('DB_PASSWORD', ''),
			'database' => env('DB_DATABASE', 'sandbox_local'), // Set in your app_local.php
		],

		/**
		 * The test connection is used during the test suite.
		 */
		'test' => [
			'password' => env('DB_PASSWORD', ''),
			'database' => 'test',
		],
	],

	'Config' => [
		'adminEmail' => '',
	],

	'Email' => [
		'default' => [
			'from' => '',
		],
	],
	'EmailTransport' => [
		'default' => [
			'host' => '',
			'username' => '',
			'password' => '',
		],
	],

	'Whoops' => [
		'editor' => true,
		'serverBasePath' => '/home/vagrant/Apps/sandbox.local',
		'userBasePath' => '',
	],
];
