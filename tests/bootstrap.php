<?php

use Cake\Log\Log;

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

$Tmp = new Cake\Filesystem\Folder(TMP);
$Tmp->create(TMP . 'cache/models', 0770);
$Tmp->create(TMP . 'cache/persistent', 0770);
$Tmp->create(TMP . 'cache/views', 0770);
$Tmp->create(LOGS, 0770);

// Ensure default test connection is defined
if (!getenv('db_class')) {
	putenv('db_class=Cake\Database\Driver\Sqlite');
	putenv('db_dsn=sqlite::memory:');
}

if (true || !WINDOWS) {
	Cake\Datasource\ConnectionManager::drop('test');
	Cake\Datasource\ConnectionManager::setConfig('test', [
		'className' => 'Cake\Database\Connection',
		'driver' => getenv('db_class'),
		'dsn' => getenv('db_dsn'),
		'database' => getenv('db_database'),
		'username' => getenv('db_username'),
		'password' => getenv('db_password'),
		'timezone' => 'UTC',
		'quoteIdentifiers' => true,
		'cacheMetadata' => true,
	]);
}
