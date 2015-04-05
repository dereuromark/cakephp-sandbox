<?php
/**
 * Test runner bootstrap.
 *
 * Add additional configuration/setup your application needs when running
 * unit tests in this file.
 */
require dirname(__DIR__) . '/config/bootstrap.php';

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

if (!empty($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] !== '127.0.0.1') {
	Cake\Datasource\ConnectionManager::drop('test');
	Cake\Datasource\ConnectionManager::config('test', [
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
