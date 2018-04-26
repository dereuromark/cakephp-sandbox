<?php
use Cake\Core\Configure;
use Cake\Core\Exception\MissingPluginException;
use Cake\Core\Plugin;

// Set logs to different files so they don't have permission conflicts.
Configure::write('Log.debug.file', 'cli-debug');
Configure::write('Log.error.file', 'cli-error');

try {
	Plugin::load('Bake');
	Plugin::load('IdeHelper');
} catch (MissingPluginException $e) {
	// Do not halt if the plugin is missing
}

Plugin::load('Migrations');

if (Configure::read('debug')) {
	Configure::write('Log.debug.className', 'File');
	Configure::write('Log.error.className', 'File');
	Configure::write('Log.404.className', 'File');
}
