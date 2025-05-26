<?php

use Cake\Core\Configure;

// Set logs to different files so they don't have permission conflicts.
Configure::write('Log.debug.file', 'cli-debug');
Configure::write('Log.error.file', 'cli-error');

if (Configure::read('debug')) {
	Configure::write('Log.debug.className', 'File');
	Configure::write('Log.error.className', 'File');
	Configure::write('Log.404.className', 'File');
}

if (!Configure::read('App.fullBaseUrl')) {
	$scheme = 'http' . (Configure::read('debug') ? '' : 's');
	Configure::write('App.fullBaseUrl', $scheme . '://sandbox.dereuromark.de');
}
