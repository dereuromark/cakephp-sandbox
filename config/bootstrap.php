<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link http://cakephp.org CakePHP(tm) Project
 * @since 0.10.8
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */

/**
 * Configure paths required to find CakePHP + general filepath
 * constants
 */
require __DIR__ . '/paths.php';

// Use composer to load the autoloader.
require ROOT . DS . 'vendor' . DS . 'autoload.php';

/**
 * Bootstrap CakePHP.
 *
 * Does the various bits of setup that CakePHP needs to do.
 * This includes:
 *
 * - Registering the CakePHP autoloader.
 * - Setting the default application paths.
 */
require CORE_PATH . 'config' . DS . 'bootstrap.php';

use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Configure\Engine\PhpConfig;
use Cake\Database\TypeFactory;
use Cake\Datasource\ConnectionManager;
use Cake\Error\ErrorTrap;
use Cake\Error\ExceptionTrap;
use Cake\Http\ServerRequest;
use Cake\I18n\Date;
use Cake\I18n\DateTime;
use Cake\I18n\Time;
use Cake\Log\Log;
use Cake\Mailer\TransportFactory;
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\Router;
use Cake\Utility\Security;
use Detection\MobileDetect;
use Tools\Mailer\Mailer;

/**
 * Load global functions.
 */
require CAKE . 'functions.php';

if (!defined('SECOND')) {
	define('SECOND', 1);
	define('MINUTE', 60);
	define('HOUR', 3600);
	define('DAY', 86400);
	define('WEEK', 604800);
	define('MONTH', 2592000);
	define('YEAR', 31536000);
}

/**
 * Read configuration file and inject configuration into various
 * CakePHP classes.
 *
 * By default there is only one configuration file. It is often a good
 * idea to create multiple configuration files, and separate the configuration
 * that changes from configuration that does not. This makes deployment simpler.
 */
try {
	Configure::config('default', new PhpConfig());
	Configure::load('app', 'default', false);
} catch (Exception $e) {
	exit($e->getMessage() . "\n");
}

Configure::load('app_custom');
Configure::load('app_local');

// Load an environment local configuration file.
// You can use a file like app_local.php to provide local overrides to your
// shared configuration.
//Configure::load('app_local', 'default');

// When debug = false the metadata cache should last
// for a very very long time, as we don't want
// to refresh the cache while users are doing requests.
if (!Configure::read('debug')) {
	Configure::write('Cache._cake_model_.duration', '+99 years');
	Configure::write('Cache._cake_core_.duration', '+99 years');
}

/**
 * Set server timezone to UTC. You can change it to another timezone of your
 * choice but using UTC makes time calculations / conversions easier.
 */
date_default_timezone_set('UTC');

/**
 * Configure the mbstring extension to use the correct encoding.
 */
mb_internal_encoding(Configure::read('App.encoding'));

/**
 * Set the default locale. This controls how dates, number and currency is
 * formatted and sets the default language to use for translations.
 */
ini_set('intl.default_locale', 'en');

/**
 * Register application error and exception handlers.
 */
(new ErrorTrap(Configure::read('Error')))->register();
(new ExceptionTrap(Configure::read('Error')))->register();

// Include the CLI bootstrap overrides.
$isCli = PHP_SAPI === 'cli';
if ($isCli) {
	require __DIR__ . '/bootstrap_cli.php';
}

/**
 * Set the full base URL.
 * This URL is used as the base of all absolute links.
 *
 * If you define fullBaseUrl in your config file you can remove this.
 */
if (!Configure::read('App.fullBaseUrl')) {
	$s = null;
	if (env('HTTPS')) {
		$s = 's';
	}

	$httpHost = env('HTTP_HOST');
	if (isset($httpHost)) {
		Configure::write('App.fullBaseUrl', 'http' . $s . '://' . $httpHost);
	}
	unset($httpHost, $s);
}

Cache::setConfig(Configure::consume('Cache'));
ConnectionManager::setConfig(Configure::consume('Datasources'));
TransportFactory::setConfig(Configure::consume('EmailTransport'));
Mailer::setConfig(Configure::consume('Email'));
Log::setConfig(Configure::consume('Log'));
Security::setSalt(Configure::consume('Security.salt'));

/**
 * Setup detectors for mobile and tablet.
 */
ServerRequest::addDetector('mobile', function ($request) {
	$detector = new MobileDetect();

	return $detector->isMobile();
});
ServerRequest::addDetector('tablet', function ($request) {
	$detector = new MobileDetect();

	return $detector->isTablet();
});

/**
 * Custom Inflector rules, can be set to correctly pluralize or singularize table, model, controller names or whatever other
 * string is passed to the inflection functions
 *
 * Inflector::rules('plural', ['/^(inflect)or$/i' => '\1ables']);
 * Inflector::rules('irregular' => ['red' => 'redlings']);
 * Inflector::rules('uninflected', ['dontinflectme']);
 * Inflector::rules('transliteration', ['/å/' => 'aa']);
 */

Router::defaultRouteClass(DashedRoute::class);
Router::extensions(['json', 'xml', 'csv', 'rss', 'pdf']);

Time::setToStringFormat('yyyy-MM-dd HH:mm:ss'); // For any mutable DateTime
DateTime::setToStringFormat('yyyy-MM-dd HH:mm:ss'); // For any immutable DateTime
Date::setToStringFormat('yyyy-MM-dd'); // For any mutable Date
Date::setToStringFormat('yyyy-MM-dd'); // For any immutable Date

TypeFactory::build('time')
	->setLocaleFormat('HH:mm:ss');
TypeFactory::build('date')
	->setLocaleFormat('dd.MM.YYYY');
TypeFactory::build('datetime')
	->setLocaleFormat('dd.MM.YYYY HH:mm:ss');
TypeFactory::build('timestamp');
/*
Type::build('time')
	->setLocaleFormat('HH:mm:ss');
Type::build('date')
	->setLocaleFormat('dd.MM.YYYY');
Type::build('datetime')
	->setLocaleFormat('dd.MM.YYYY HH:mm:ss');

FrozenTime::setToStringFormat('dd.MM.YYYY HH:mm:ss');
Time::setToStringFormat('dd.MM.YYYY HH:mm:ss');
FrozenDate::setToStringFormat('dd.MM.YYYY');
Date::setToStringFormat('dd.MM.YYYY');
 */

//TypeFactory::map()...;
