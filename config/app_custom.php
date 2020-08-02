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

	'Log' => [
		'debug' => [
			'scopes' => false,
			'className' => 'DatabaseLog.Database',
		],
		'error' => [
			'scopes' => false,
			'className' => 'DatabaseLog.Database',
		],
		'404' => [
			'className' => 'DatabaseLog.Database',
			'file' => '404',
			'levels' => ['error'],
			'scopes' => ['404'],
		],
	],

	'Datasources' => [
		'default' => [
			'host' => env('MYSQL_HOST', 'localhost'),
			'username' => env('MYSQL_USERNAME', 'root'),
			'database' => env('MYSQL_DB', ''), // Set in your app_local.php
			'password' => '', // Set in your app_local.php
			'quoteIdentifiers' => true,
			'url' => getenv('DB_DSN') ?: null,
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

	'Feedback' => [
		'stores' => [
		],
		'returnlink' => true,
		'enableacceptterms' => true,
		'enablecopybyemail' => false,
		'termstext' => true,
		'configuration' => [
			'Filesystem' => [
				'location' => ROOT . DS . 'tmp' . DS . 'feedback' . DS,
			],
		],
	],

	'Config' => [
		'adminEmail' => null, // Set in your app_local.php
	],

	'App' => [
		'monitorHeaders' => 1,
		'defaultOutputTimezone' => 'Europe/Berlin',
		'stats' => false,
	],

	'CakeDto' => [
		'strictTypes' => false,
		'scalarTypeHints' => false,
	],

	'DebugKit' => [
		'panels' => [
			'DebugKit.Packages' => false,
			'DebugKit.Mail' => false,
			'TinyAuth.Auth' => true,
		],
	],

	'FormConfig' => [
		'novalidate' => true,
		'templates' => [
			'dateWidget' => '{{day}}{{month}}{{year}}{{hour}}{{minute}}{{second}}{{meridian}}',
		],
		'align' => 'horizontal',
	],

	'Format' => [
		'iconNamespaces' => [
			'fa',
			'glyphicon',
		],
		'fontPath' => ROOT . DS . 'node_modules/font-awesome/scss/_variables.scss', // For FormatIconTask
		'fontIcons' => [
			'see' => 'fa fa-eye',
			'details' => 'fa fa-chevron-right',
			'admin' => 'fa fa-shield',
			'login' => 'fa fa-sign-in',
			'logout' => 'fa fa-sign-out',
			'translate' => 'fa fa-language',
			'prev' => 'fa fa-arrow-left',
			'next' => 'fa fa-arrow-right',
		],
	],

	'CacheConfig' => [
		'check' => null,
		'engine' => 'default',
	],

	'EmailTransport' => [
		'default' => [
			'className' => 'Smtp',
			'tls' => true,
			'port' => 587,
		],
	],

	'Email' => [
		'default' => [
			'from' => null,
		],
	],

	'IdeHelper' => [
		'plugins' => [
			'Ratings',
			'Tags',
			'Meta',
		],
		'annotators' => [
			\IdeHelper\Annotator\EntityAnnotator::class => \Shim\Annotator\EntityAnnotator::class,
		],
		'generatorTasks' => [
			\Burzum\CakeServiceLayer\Generator\Task\ServiceTask::class,
			\IdeHelperExtra\Tools\Generator\Task\FormatIconFontAwesome4Task::class,
		],
		'classAnnotatorTasks' => [
			\Burzum\CakeServiceLayer\Annotator\ClassAnnotatorTask\ServiceAwareClassAnnotatorTask::class,
		],
		'includedPlugins' => [
			'Sandbox',
			'AuthSandbox',
		],
		'typeMap' => [
		],
	],

	'Highlighter' => [
		'highlighter' => 'Markup\Highlighter\JsHighlighter',
	],

	'Queue' => [
		'sleeptime' => 5,
		'gcprob' => 10,
		'maxworkers' => 3,
		// time (in seconds) after which a job is requeued if the worker doesn't report back
		'defaultworkertimeout' => 1800,
		// number of retries if a job fails or times out.
		'defaultworkerretries' => 1,
		// seconds of running time after which the worker will terminate (0 = unlimited)
		'workermaxruntime' => 125,
		// instruct a Workerprocess quit when there are no more tasks for it to execute (true = exit, false = keep running)
		'exitwhennothingtodo' => false,
		// minimum time (in seconds) which a task remains in the database before being cleaned up.
		'cleanuptimeout' => 2592000, // 30 days
	],

	'Shim' => [
		'deprecations' => true,
		'deprecationType' => E_USER_NOTICE,
	],

	'Geocoder' => [
		'apiKey' => '',
	],

	'GoogleMap' => [
		'key' => '',
	],
];
