<?php

use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Shim\Filesystem\Folder;
use Cake\Log\Log;
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\Router;

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
if (!getenv('db_class')) {
	putenv('db_class=Cake\Database\Driver\Sqlite');
	putenv('db_dsn=sqlite::memory:');
}

Router::defaultRouteClass(DashedRoute::class);

require ROOT . '/config/routes.php';

require ROOT . '/vendor/dereuromark/cakephp-tools/config/bootstrap.php';

ConnectionManager::drop('test');
ConnectionManager::setConfig('test', [
	'className' => 'Cake\Database\Connection',
	'driver' => getenv('db_class') ?: null,
	'dsn' => getenv('db_dsn') ?: null,
	//'database' => getenv('db_database'),
	//'username' => getenv('db_username'),
	//'password' => getenv('db_password'),
	'timezone' => 'UTC',
	'quoteIdentifiers' => true,
	'cacheMetadata' => true,
]);

Configure::write('Error.ignoredDeprecationPaths', [
	'src/TestSuite/Fixture/FixtureInjector.php',
	'vendor/*',
]);

// Fixate sessionid early on, as php7.2+
// does not allow the sessionid to be set after stdout
// has been written to.
session_id('cli');
