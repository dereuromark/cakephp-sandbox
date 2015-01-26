<?php
return [
	//'debug' => true,

	'Security' => [
		'salt' => '9ebcb009bb3f8ebe43a4addc3fc1c1f310c50520',
	],

	'Datasources' => [
		'default' => [
			'host' => 'localhost',
			'username' => 'root',
			'password' => '',
			'database' => 'cake_sandbox',
		],

		/**
		 * The test connection is used during the test suite.
		 */
		'test' => [
			'host' => 'localhost',
			'username' => 'root',
			'password' => '',
			'database' => 'cake_test',
		],
	],

	'Config' => array(
		'adminEmail' => 'youremail@host.de'
	),

	'FormConfig' => array(
		'novalidate' => true,
		'templates' => array(
			'dateWidget' => '{{day}}{{month}}{{year}}{{hour}}{{minute}}{{second}}{{meridian}}',
		)
	)

];
