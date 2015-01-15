<?php
$config = [
	'debug' => false,

	'Security' => [
		'salt' => '0ebcb009bb3f8ebe43a4addc3fc1c1f310c50520',
	],

	'Datasources' => [
		'default' => [
			'host' => 'localhost',
			'username' => 'root',
			'password' => '',
			'database' => '', // Set in your app_local.php
		],

		/**
		 * The test connection is used during the test suite.
		 */
		'test' => [
			'host' => 'localhost',
			'username' => 'root',
			'password' => '',
			'database' => '', // Set in your app_local.php
		],
	],

	'Config' => array(
		'adminEmail' => '' // Set in your app_local.php
	),

	'App' => array(
		'monitorHeaders' => 1
	),

	'FormConfig' => array(
		'novalidate' => true,
		'templates' => array(
			'dateWidget' => '{{day}}{{month}}{{year}}{{hour}}{{minute}}{{second}}{{meridian}}',
		)
	)

];
