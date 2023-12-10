<?php

use Burzum\CakeServiceLayer\Annotator\ClassAnnotatorTask\ServiceAwareClassAnnotatorTask;
use Burzum\CakeServiceLayer\Generator\Task\ServiceTask;
use Cake\Core\Configure;
use Cake\Event\EventInterface;
use IdeHelper\Annotator\EntityAnnotator;
use IdeHelperExtra\Tools\Generator\Task\IconRenderTask;
use Queue\Utility\JsonSerializer;
use Shim\Annotator\EntityAnnotator as ShimEntityAnnotator;
use StateMachine\Graph\Adapter\PhpDocumentorGraphAdapter;
use StateMachine\Illuminator\Task\EventTask;
use StateMachine\Illuminator\Task\StateTask;
use StateMachineSandbox\StateMachine\RegistrationStateMachineHandler;
use Tools\Error\ErrorLogger;
use Tools\Mailer\Mailer;
use Template\View\Icon\BootstrapIcon;
use Template\View\Icon\FeatherIcon;
use Template\View\Icon\FontAwesome4Icon;
use Template\View\Icon\FontAwesome6Icon;
use Template\View\Icon\MaterialIcon;

$debug = false;
if (env('HTTP_HOST') === 'localhost' || env('HTTP_HOST') === 'sandbox.local') {
	$debug = true;
}

$config = [
	'debug' => filter_var(env('DEBUG', $debug), FILTER_VALIDATE_BOOLEAN),

	'Security' => [
		'salt' => '0ebcb009bb3f8ebe43a4addc3fc1c1f310c50520',
	],

	'Error' => [
		'logger' => ErrorLogger::class,
	],

	'Log' => [
		'debug' => [
			//'className' => 'File',
			'className' => 'DatabaseLog.Database',
			'scopes' => null,
		],
		'error' => [
			//'className' => 'File',
			'className' => 'DatabaseLog.Database',
			'scopes' => null,
		],
		'404' => [
			//'className' => 'File',
			'className' => 'DatabaseLog.Database',
			'file' => '404',
			'levels' => ['error'],
			'scopes' => ['404'],
		],
	],

	'Datasources' => [
		'default' => [
			'host' => '127.0.0.1',
			'username' => 'root',
			'password' => '',
			'database' => '', // Set in your app_local.php
			'quoteIdentifiers' => true,
			'url' => env('DB_URL') ?: null,
			'flags' => [
			],
		],

		/**
		 * The test connection is used during the test suite.
		 */
		'test' => [
			'host' => '127.0.0.1',
			'username' => 'root',
			'password' => '',
			'database' => '', // Set in your app_local.php
			'quoteIdentifiers' => true,
			'url' => env('DB_URL') ?: null,
			'flags' => [
			],
		],
	],

	'Session' => [
		//'defaults' => 'database',
		'timeout' => 60000,
		'ini' => [
			'session.cookie_lifetime' => WEEK,
		],
	],

	'DatabaseLog' => [
		'datasource' => 'default',
		'limit' => 99999,
		'maxLength' => '-1 month',
		'monitor' => [
			'cli-error',
			'cli-warning',
			'error',
			'warning',
			'notice',
		],
		'monitorCallback' => function (EventInterface $event) {
			/** @var \DatabaseLog\Model\Table\DatabaseLogsTable $logsTable */
			$logsTable = $event->getSubject();

			/* @var \DatabaseLog\Model\Entity\DatabaseLog[] $logs */
			$logs = $event->getData('logs');

			$content = '';
			foreach ($logs as $log) {
				$content .= $logsTable->format($log);
			}

			$mailer = new Mailer();
			$mailer->setTo(Configure::read('Config.adminEmail'));
			$subject = count($logs) . ' new error log entries';
			$mailer->setSubject($subject);
			$mailer->deliver($content);
		},
	],

	'Migrations' => [
		'unsigned_primary_keys' => true,
		'column_null_default' => true,
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
	],

	'DebugKit' => [
		'panels' => [
			'DebugKit.Packages' => false,
			'DebugKit.Mail' => false,
			'TinyAuth.Auth' => true,
		],
	],

	'StateMachine' => [
		'graphAdapter' => PhpDocumentorGraphAdapter::class,
		'handlers' => [
			RegistrationStateMachineHandler::class,
		],
		'map' => [
		],
		'pathToXml' => ROOT . DS . 'plugins' . DS . 'StateMachineSandbox' . DS . 'config' . DS . 'StateMachines' . DS,
	],

	'FormConfig' => [
		'novalidate' => true,
		/*
		'templates' => [
			'dateWidget' => '{{day}}{{month}}{{year}}{{hour}}{{minute}}{{second}}{{meridian}}',
		],
		*/
		'align' => 'horizontal',
	],

	'Icon' => [
		'sets' => [
			'fa4' => [
				'class' => FontAwesome4Icon::class,
				'path' => WWW_ROOT . 'assets/font-awesome/less/variables.less',
			],
			'fa6' => [
				'class' => FontAwesome6Icon::class,
				'path' => WWW_ROOT . 'assets/fontawesome-free/metadata/icons.json',
			],
			'bs' => [
				'class' => BootstrapIcon::class,
				'path' => WWW_ROOT . 'assets/bootstrap-icons/font/bootstrap-icons.json',
			],
			'material' => [
				'class' => MaterialIcon::class,
				'path' => WWW_ROOT . 'assets/material-symbols/index.d.ts',
				'namespace' => 'material-symbols-outlined',
			],
			'feather' => [
				'class' => FeatherIcon::class,
				'path' => WWW_ROOT . 'assets/feather-icons/dist/icons.json',
			],
		],
		'map' => [
			'view' => 'fa4:eye',
			'delete' => 'fa4:times',
			'yes' => 'fa4:check',
			'no' => 'fa4:times',
			'see' => 'fa4:eye',
			'details' => 'fa4:chevron-right',
			'admin' => 'fa4:shield',
			'login' => 'fa4:sign-in',
			'logout' => 'fa4:sign-out',
			'translate' => 'fa4:language',
			'prev' => 'fa4:arrow-left',
			'next' => 'fa4:arrow-right',
			'chart-bar' => 'fa4:bar-chart',
			'pro' => 'fa4:thumbs-up',
			'contra' => 'fa4:thumbs-down',
		],
		'checkExistence' => true,
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
		'arrayAsGenerics' => true,
		'objectAsGenerics' => true,
		'templateCollectionObject' => 'iterable',
		'annotators' => [
			EntityAnnotator::class => ShimEntityAnnotator::class,
		],
		'generatorTasks' => [
			ServiceTask::class,
			IconRenderTask::class,
		],
		'classAnnotatorTasks' => [
			ServiceAwareClassAnnotatorTask::class,
		],
		'illuminatorTasks' => [
			StateTask::class,
			EventTask::class,
		],
		'includedPlugins' => [
			'Sandbox',
			'AuthSandbox',
			'StateMachineSandbox',
		],
		'typeMap' => [
		],
	],

	'Highlighter' => [
		'highlighter' => 'Markup\Highlighter\JsHighlighter',
	],

	'Queue' => [
		'serializerClass' => JsonSerializer::class,
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

	'Captcha' => [
		'maxPerUser' => 5,
	],

	'Geocoder' => [
		'apiKey' => '',
	],

	'GoogleMap' => [
		'key' => '',
	],
];

if (str_contains(getenv('DB_URL'), 'mysql')) {
	$config['Datasources']['default']['flags'][PDO::MYSQL_ATTR_INIT_COMMAND] = "SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''))";
	$config['Datasources']['default']['test'][PDO::MYSQL_ATTR_INIT_COMMAND] = "SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''))";
}

return $config;
