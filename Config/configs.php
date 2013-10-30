<?php

$config['Debug'] = array(
	'helper' => 1,
	'check_for_cake_version' => 0, # gecached 24 hours :-)
	'check_for_php_version' => 0, # gecached 48 hours :-)
	'ajax_remember' => 1,	# ajax remember current tab
	'override' => 1 # if cache etc is usually disabled in debug mode, this overrides it
);

$config['Role'] = array(
	'admin' => '1',
	'user' => '2',
);

$config['Asset'] = array(
	'js' => 'buffer'
);

/** private information holder */
$config['Mail'] = array(
	'debug' => 0,	# 0=no,1=flashMessageAfterwards,2=fullDebug(noMailSent)
	'log' => 1,
	'use_smtp' => 1,
	'smtp_port' => 25,
	'smtp_timeout' => 20,
	'smtp_host' => '',
	'smtp_username' => '',
	'smtp_password' => '',
);

$config['Google'] = array(
	'key' => '',
	'api' => '2.x',
	'zoom' => 6,
	'lat' => 51,
	'lng' => 11,
	'type' => 'G_NORMAL_MAP',
 	'static_size' => '500x500'
);

$config['Config'] = array(
	'language' => 'en',
	'admin_name' => 'Site Owner',
	'admin_email' => 'test@test.de',
	'admin_emailname' => 'Site Owner',
	'no_reply_email' => 'noreply@test.de',
	'no_reply_emailname' => '',
	'page_name' => 'Sandbox',
	'domain_name' => 'CakePHP Sandbox',
	'keywords' => '',
	'description' => '',
);

/** end: private information holder */

$config['Paginator'] = array(
	'paramType' => 'querystring'
);

$config['Settings'] = array(
	'version' => '1.0',
	'title' => 'CakePHP Sandbox',
);

$config['Caching'] = array(
	'default' => '+4 hours',
	'short' => '+1 day',
	'medium' => '+1 week',
	'long' => '+1 month',
	'test' => '+30 seconds',
	'url_cache_type' => 'pages' # pages (single pages) / combined (all together) / false
);

$config['LanguagesAvailable'] = array( # supported languages
	//'de',
	'en',
	//'it'
);

$config['Languages'] = array(
	'de' => '',
	'en' => '',
	'it' => ''
);

$config['Currency'] = array(
	'code' => 'USD',
	'symbolLeft' => '',
	'symbolRight' => '$',
	'places' => '2',
	'thousands' => ',',
	'decimals' => '.',
);

$config['Localization'] = array(
	'address_format' => 'en',
	'thousands' => ',',
	'decimals' => '.',
);

$config['AutoLogin'] = array(
	'active' => 1,
	'controller' => 'account',
	'username' => 'login',
	'debug' => 0,
);

$config['Validation'] = array(
	//'autoRequire' => false,
	'browserAutoRequire' => false,
);

$config['Queue'] = array(
	'workermaxruntime' => 40 * MINUTE,
	'sleeptime' => 20,
	'defaultworkertimeout' => 40 * MINUTE,
	'log' => true
);

$config['Search'] = array(
	'Prg' => array(
		'commonProcess' => array('paramType' => 'querystring', 'filterEmpty' => true),
		'presetForm' => array('paramType' => 'querystring')
	),
	'Searchable' => array(),
);
