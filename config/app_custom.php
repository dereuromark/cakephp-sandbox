<?php
$debug = false;
if (env('HTTP_HOST') === 'localhost' || env('HTTP_HOST') === 'sandbox.local') {
	$debug = true;
}

return [
	'debug' => $debug,

	'Security' => [
		'salt' => '0ebcb009bb3f8ebe43a4addc3fc1c1f310c50520',
	],

	'Datasources' => [
		'default' => [
			'host' => 'localhost',
			'username' => 'root',
			'password' => '',
			'database' => '', // Set in your app_local.php
			'quoteIdentifiers' => true,
		],

		/**
		 * The test connection is used during the test suite.
		 */
		'test' => [
			'host' => 'localhost',
			'username' => 'root',
			'password' => '',
			'database' => '', // Set in your app_local.php
			'quoteIdentifiers' => true,
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
	),

	'EmailTransport' => array(
		'default' => array(
			'className' => 'Smtp',
			'tls' => true,
			'port' => 587
		)
	),

	'Email' => array(
		'default' => array(
			'from' => ''
		)
	)

];
