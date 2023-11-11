<?php

return [
	'debug' => filter_var(env('DEBUG', true), FILTER_VALIDATE_BOOLEAN),

	'Datasources' => [
		'default' => [
			'username' => 'my_app',
			'password' => 'secret',
			'database' => 'my_app',
		],

		/**
		 * The test connection is used during the test suite.
		 */
		'test' => [
			'username' => 'my_app',
			'password' => 'secret',
			'database' => 'test_myapp',
		],
	],
];
