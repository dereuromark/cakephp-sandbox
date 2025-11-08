<?php

use Cake\Core\Configure;
use Cake\Event\EventInterface;
use IdeHelper\Annotator\EntityAnnotator;
use Shim\Annotator\EntityAnnotator as ShimEntityAnnotator;
use StateMachine\Graph\Adapter\PhpDocumentorGraphAdapter;
use StateMachine\Illuminator\Task\EventTask;
use StateMachine\Illuminator\Task\StateTask;
use StateMachineSandbox\StateMachine\RegistrationStateMachineHandler;
use Templating\Generator\Task\IconRenderTask;
use Templating\View\Icon\BootstrapIcon;
use Templating\View\Icon\FeatherIcon;
use Templating\View\Icon\FontAwesome6Icon;
use Templating\View\Icon\MaterialIcon;
use Tools\Error\ErrorLogger;
use Tools\Mailer\Mailer;

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
			'host' => env('DB_HOST', '127.0.0.1'),
			'username' => env('DB_USER', 'root'),
			'password' => env('DB_PASSWORD', ''),
			'database' => env('DB_DATABASE', ''), // Set in your app_local.php
			'quoteIdentifiers' => true,
			'url' => env('DB_URL') ?: null,
			'flags' => [],
		],

		/**
		 * The test connection is used during the test suite.
		 */
		'test' => [
			'host' => env('DB_HOST', '127.0.0.1'),
			'username' => env('DB_USER', 'root'),
			'password' => env('DB_PASSWORD', ''),
			'database' => 'test', // Set in your app_local.php
			'quoteIdentifiers' => true,
			'url' => env('DB_URL') ?: null,
			'flags' => [],
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
		'disableAutoTable' => true,
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
		'stores' => [],
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
		'maxDepth' => 8,
		'panels' => [
			'DebugKit.Packages' => false,
			'DebugKit.Mail' => false,
			'TinyAuth.Auth' => true,
			'Setup.L10n' => true,
		],
	],

	'Setup' => [
		'Healthcheck' => [
			'checks' => [
				\Setup\Healthcheck\Check\Environment\PhpUploadLimitCheck::class => [
					'min' => 16,
				],
					// ...
			] + \Setup\Healthcheck\HealthcheckCollector::defaultChecks(),
		],
	],

	'StateMachine' => [
		'graphAdapter' => PhpDocumentorGraphAdapter::class,
		'handlers' => [
			RegistrationStateMachineHandler::class,
		],
		'map' => [],
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
			'fa6' => [
				'class' => FontAwesome6Icon::class,
				'path' => WWW_ROOT . 'assets/@fortawesome/fontawesome-free/metadata/icon-families.json',
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
				'svgPath' => true,
			],
		],
		'map' => [
			'add' => 'fa6:plus',
			'view' => 'fa6:eye',
			'delete' => 'fa6:xmark',
			'yes' => 'fa6:check',
			'no' => 'fa6:xmark',
			'see' => 'fa6:eye',
			'details' => 'fa6:chevron-right',
			'admin' => 'fa6:shield',
			'login' => 'fa6:right-to-bracket',
			'logout' => 'fa6:right-from-bracket',
			'translate' => 'fa6:language',
			'prev' => 'fa6:arrow-left',
			'next' => 'fa6:arrow-right',
			'chart-bar' => 'fa6:chart-column',
			'pro' => 'fa6:thumbs-up',
			'contra' => 'fa6:thumbs-down',
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
			IconRenderTask::class,
		],
		'classAnnotatorTasks' => [],
		'illuminatorTasks' => [
			StateTask::class,
			EventTask::class,
		],
		'includedPlugins' => [
			'Sandbox',
			'AuthSandbox',
			'StateMachineSandbox',
		],
		'typeMap' => [],
	],

	'Highlighter' => [
		'highlighter' => 'Markup\Highlighter\JsHighlighter',
	],

	'Queue' => [
		'sleeptime' => 5,
		'gcprob' => 10,
		'maxworkers' => 2,
		// seconds of running time after which the worker will terminate (0 = unlimited)
		'workerLifetime' => 60,
		// PHP timeout for a single job execution
		'workerPhpTimeout' => 120,
		// time (in seconds) after which a job is requeued if the worker doesn't report back
		'defaultRequeueTimeout' => 130,
		// number of retries if a job fails or times out.
		'defaultworkerretries' => 1,
		// instruct a Workerprocess quit when there are no more tasks for it to execute (true = exit, false = keep running)
		'exitwhennothingtodo' => false,
		// minimum time (in seconds) which a task remains in the database before being cleaned up.
		'cleanuptimeout' => 2592000, // 30 days
	],

	'QueueScheduler' => [
		'allowRaw' => true, // By default, this is only enabled in debug mode for security reasons.
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

	'Geo' => [
		'spatial' => true,
	],

	'GoogleMap' => [
		'key' => '',
	],

	'Favorites' => [
		'models' => [
			'StarPosts' => 'Sandbox.SandboxPosts',
			'LikePosts' => 'Sandbox.SandboxPosts',
			'FavoritePosts' => 'Sandbox.SandboxPosts',
		],
		'userModelClass' => 'Sandbox.SandboxUsers',
		'icons' => \Favorites\View\Helper\FavoritesHelper::ICONS_GITHUB,
	],

	'Comments' => [
		'allowAnonymous' => true,
	],

	'AuditStash' => [
		'persister' => \AuditStash\Persister\TablePersister::class,
	],

	'FileStorage' => (function() {
		if (!defined('UPLOADS_DIR')) {
			define('UPLOADS_DIR', WWW_ROOT . 'files' . DS . 'uploads' . DS);
		}

		// Storage setup
		$storageFactory = new \PhpCollective\Infrastructure\Storage\StorageAdapterFactory();
		$storageService = new \PhpCollective\Infrastructure\Storage\StorageService(
			$storageFactory,
		);
		$storageService->addAdapterConfig(
			'Local',
			\PhpCollective\Infrastructure\Storage\Factories\LocalFactory::class,
			[
				'root' => UPLOADS_DIR,
			],
		);

		$pathBuilder = new \PhpCollective\Infrastructure\Storage\PathBuilder\PathBuilder([
			'pathTemplate' => '{model}{ds}{collection}{ds}{randomPath}{ds}{id}{ds}{filename}.{extension}',
			'variantPathTemplate' => '{model}{ds}{collection}{ds}{randomPath}{ds}{id}{ds}{filename}.{hashedVariant}.{extension}',
			'randomPathLevels' => 1,
			'sanitizer' => new \PhpCollective\Infrastructure\Storage\Utility\FilenameSanitizer([
				'urlSafe' => true,
				'removeUriReservedChars' => true,
				'maxLength' => 190,
			]),
		]);
		$fileStorage = new \PhpCollective\Infrastructure\Storage\FileStorage(
			$storageService,
			$pathBuilder,
		);

		// Image Manager and Processor
		$imageManager = \Intervention\Image\ImageManager::gd();
		$imageProcessor = new \PhpCollective\Infrastructure\Storage\Processor\Image\ImageProcessor(
			$fileStorage,
			$pathBuilder,
			$imageManager,
		);

		// PDF thumbnail processor
		$pdfProcessor = new \Sandbox\FileStorage\Processor\PdfThumbnailProcessor($imageProcessor);

		// Unified processor - handles both images and PDFs
		$unifiedProcessor = new \Sandbox\FileStorage\Processor\UnifiedFileProcessor(
			$imageProcessor,
			$pdfProcessor,
		);

		// Configure image variants for different collections
		$imageVariants = \PhpCollective\Infrastructure\Storage\Processor\Image\ImageVariantCollection::create();
		$imageVariants->addNew('thumbnail')
			->cover(150, 150) // zoom-crop to fill entire 150x150
			->optimize();
		$imageVariants->addNew('medium')
			->resize(400, 400)
			->optimize();
		$imageVariants->addNew('large')
			->resize(800, 800)
			->optimize();

		// Configure PDF preview variants (same as images)
		$pdfVariants = \PhpCollective\Infrastructure\Storage\Processor\Image\ImageVariantCollection::create();
		$pdfVariants->addNew('thumbnail')
			->cover(150, 150)
			->optimize();
		$pdfVariants->addNew('medium')
			->resize(400, 400)
			->optimize();
		$pdfVariants->addNew('large')
			->resize(800, 800)
			->optimize();

		// Square crop variants
		$squareVariants = \PhpCollective\Infrastructure\Storage\Processor\Image\ImageVariantCollection::create();
		$squareVariants->addNew('thumb_square')
			->cover(150, 150)
			->optimize();
		$squareVariants->addNew('medium_square')
			->cover(300, 300)
			->optimize();

		return [
			'pathPrefix' => 'files/uploads/',
			// Image variants configuration per model/collection
			// Model name is the Table alias (FileStorage), not the custom model field value
			'imageVariants' => [
				'FileStorage' => [
					'images' => $imageVariants->toArray(),
					'pdfs' => $pdfVariants->toArray(), // PDF preview variants
					'general' => [], // No variants for general files
				],
			],
			'behaviorConfig' => [
				'fileStorage' => $fileStorage,
				'fileProcessor' => $unifiedProcessor,
				'fileValidator' => null,
			],
		];
	})(),
];

if (str_contains((string)getenv('DB_URL'), 'mysql')) {
	$config['Datasources']['default']['flags'][PDO::MYSQL_ATTR_INIT_COMMAND] = "SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''))";
	$config['Datasources']['test']['flags'][PDO::MYSQL_ATTR_INIT_COMMAND] = "SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''))";
}

return $config;
