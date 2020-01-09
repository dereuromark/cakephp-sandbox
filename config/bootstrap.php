<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.8
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
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

use App\Error\ErrorHandler;
use Cake\Cache\Cache;
use Cake\Error\ConsoleErrorHandler;
use Cake\Core\Configure;
use Cake\Core\Configure\Engine\PhpConfig;
use Cake\Database\Type;
use Cake\Datasource\ConnectionManager;
use Cake\Http\ServerRequest;
use Cake\I18n\Date;
use Cake\I18n\FrozenDate;
use Cake\I18n\FrozenTime;
use Cake\I18n\Time;
use Cake\Log\Log;
use Cake\Mailer\TransportFactory;
use Cake\Routing\Router;
use Cake\Utility\Security;
use Tools\Mailer\Email;

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
} catch (\Exception $e) {
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
$isCli = PHP_SAPI === 'cli';
if ($isCli) {
	(new ConsoleErrorHandler(Configure::consume('Error')))->register();
} else {
	(new ErrorHandler(Configure::consume('Error')))->register();
}

// Include the CLI bootstrap overrides.
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
Email::setConfig(Configure::consume('Email'));
Log::setConfig(Configure::consume('Log'));
Security::setSalt(Configure::consume('Security.salt'));

/**
 * Setup detectors for mobile and tablet.
 */
ServerRequest::addDetector('mobile', function ($request) {
	$detector = new \Detection\MobileDetect();
	return $detector->isMobile();
});
ServerRequest::addDetector('tablet', function ($request) {
	$detector = new \Detection\MobileDetect();
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

Router::extensions(['json', 'xml', 'csv', 'rss', 'pdf']);

Time::setToStringFormat('yyyy-MM-dd HH:mm:ss'); // For any mutable DateTime
FrozenTime::setToStringFormat('yyyy-MM-dd HH:mm:ss'); // For any immutable DateTime
Date::setToStringFormat('yyyy-MM-dd'); // For any mutable Date
FrozenDate::setToStringFormat('yyyy-MM-dd'); // For any immutable Date

Type::build('time')
	->useImmutable()->setLocaleFormat('HH:mm:ss');
Type::build('date')
	->useImmutable()->setLocaleFormat('dd.MM.YYYY');
Type::build('datetime')
	->useImmutable()->setLocaleFormat('dd.MM.YYYY HH:mm:ss');
Type::build('timestamp')
	->useImmutable();
/*
Type::build('time')
	->useImmutable()->setLocaleFormat('HH:mm:ss');
Type::build('date')
	->useImmutable()->setLocaleFormat('dd.MM.YYYY');
Type::build('datetime')
	->useImmutable()->setLocaleFormat('dd.MM.YYYY HH:mm:ss');

FrozenTime::setToStringFormat('dd.MM.YYYY HH:mm:ss');
Time::setToStringFormat('dd.MM.YYYY HH:mm:ss');
FrozenDate::setToStringFormat('dd.MM.YYYY');
Date::setToStringFormat('dd.MM.YYYY');
 */

/**
 * Plugins need to be loaded manually, you can either load them one by one or all of them in a single call
 * Uncomment one of the lines below, as you need. make sure you read the documentation on Plugin to use more
 * advanced ways of loading plugins
 *
 * Plugin::loadAll(); // Loads all plugins at once
 * Plugin::load('DebugKit'); //Loads a single plugin named DebugKit
 */
/*
Plugin::load('DebugKit', ['bootstrap' => true]);

Plugin::load('Setup', ['bootstrap' => true]);
Plugin::load('Tools', ['bootstrap' => true]);
Plugin::load('Data', ['routes' => true]);
Plugin::load('Setup', ['bootstrap' => true]);
Plugin::load('Sandbox', ['routes' => true]);
Plugin::load('AuthSandbox', ['routes' => true]);
Plugin::load('AssetCompress', ['bootstrap' => true]);
Plugin::load('BootstrapUI');
Plugin::load('Search');
Plugin::load('Geo');
Plugin::load('Ratings');
Plugin::load('Tags');
Plugin::load('TinyAuth');
Plugin::load('Queue', ['routes' => true, 'bootstrap' => true]);
Plugin::load('Feedback', ['routes' => true, 'bootstrap' => true]);

Plugin::load('CakePdf', ['routes' => true]);
Plugin::load('Cache', ['routes' => true]);
Plugin::load('Captcha', ['bootstrap' => true, 'routes' => true]);
Plugin::load('DatabaseLog', ['bootstrap' => true, 'routes' => true]);
Plugin::load('CakeDto', ['bootstrap' => true]);

if (Configure::read('debug')) {
	Plugin::load('TestHelper', ['routes' => true]);
}
*/
