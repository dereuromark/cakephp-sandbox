<?php

use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Cake\Log\Log;
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\Router;
use Shim\Filesystem\Folder;

require dirname(__DIR__) . '/vendor/autoload.php';
require dirname(__DIR__) . '/config/bootstrap.php';

$_SERVER['PHP_SELF'] = '/';

// Tests should log to file instead of the default configured DatabaseLog
$logs = Log::configured();
foreach ($logs as $log) {
	$config = Log::getConfig($log);
	if ($config['className'] === 'Cake\Log\Engine\FileLog') {
		continue;
	}
	Log::drop($log);
	Log::setConfig($log, [
		'className' => 'Cake\Log\Engine\FileLog',
		'path' => LOGS,
	] + $config);
}

$Tmp = new Folder(TMP);
$Tmp->create(TMP . 'cache/models', 0770);
$Tmp->create(TMP . 'cache/persistent', 0770);
$Tmp->create(TMP . 'cache/views', 0770);
$Tmp->create(LOGS, 0770);

// Ensure default test connection is defined
if (!getenv('DB_CLASS')) {
	putenv('DB_CLASS=Cake\Database\Driver\Sqlite');
	putenv('DB_URL=sqlite:///:memory:');
}

Router::defaultRouteClass(DashedRoute::class);

require ROOT . '/config/routes.php';

require ROOT . '/vendor/dereuromark/cakephp-tools/config/bootstrap.php';

// Ensure default test connection is defined
if (getenv('DB_URL') === 'sqlite:///:memory:') {
	ConnectionManager::drop('test');
	ConnectionManager::setConfig('test', [
		'url' => getenv('DB_URL') ?: null,
		'encoding' => 'utf8mb4',
		'quoteIdentifiers' => true,
		'cacheMetadata' => true,
	]);
}

Configure::write('Error.ignoredDeprecationPaths', [
	'vendor/*',
]);

// Fixate sessionid early on, as php7.2+
// does not allow the sessionid to be set after stdout
// has been written to.
session_id('cli');

(new \Migrations\TestSuite\Migrator())->runMany([
	['connection' => 'test'],
	['plugin' => 'StateMachine'],
	['plugin' => 'Tags'],
	['plugin' => 'Captcha'],
	['plugin' => 'Queue'],
	['plugin' => 'Favorites'],
	['plugin' => 'Comments'],
]);
