<?php

$config['Debug'] = [
	'helper' => 1,
	'check_for_cake_version' => 0, # gecached 24 hours :-)
	'check_for_php_version' => 0, # gecached 48 hours :-)
	'ajax_remember' => 1,	# ajax remember current tab
	'override' => 1 # if cache etc is usually disabled in debug mode, this overrides it
];

$config['Role'] = [
	'admin' => '1',
	'user' => '2',
];

$config['Asset'] = [
	'js' => 'buffer'
];

$config['Passwordable'] = [
	'authType' => 'Blowfish'
];

/**
 * private information holder
 */
$config['Mail'] = [
	'debug' => 0,	# 0=no,1=flashMessageAfterwards,2=fullDebug(noMailSent)
	'log' => 1,
	'useSmtp' => 1,
	'smtpPort' => 25,
	'smtpTimeout' => 20,
	'smtpHost' => '',
	'smtpUsername' => '',
	'smtpPassword' => '',
];

$config['Google'] = [
	'key' => '',
	'api' => '2.x',
	'zoom' => 6,
	'lat' => 51,
	'lng' => 11,
	'type' => 'G_NORMAL_MAP',
 	'static_size' => '500x500'
];

$config['Config'] = [
	'language' => 'en',
	'adminName' => 'Site Owner',
	'adminEmail' => 'test@test.de',
	'noReplyEmail' => 'noreply@test.de',
	'noReplyEmailname' => '',
	'keywords' => '',
	'description' => '',
];

$config['Paginator'] = [
	'paramType' => 'querystring'
];

$config['Settings'] = [
	'version' => '1.0',
	'title' => 'CakePHP Sandbox',
];

$config['Caching'] = [
	'default' => '+4 hours',
	'short' => '+1 day',
	'medium' => '+1 week',
	'long' => '+1 month',
	'test' => '+30 seconds',
	'url_cache_type' => 'pages' # pages (single pages) / combined (all together) / false
];

$config['LanguagesAvailable'] = [ # supported languages
	//'de',
	'en',
	//'it'
];

$config['Languages'] = [
	'de' => '',
	'en' => '',
	'it' => ''
];

$config['Currency'] = [
	'code' => 'USD',
	'symbolLeft' => '',
	'symbolRight' => '$',
	'places' => '2',
	'thousands' => ',',
	'decimals' => '.',
];

$config['Localization'] = [
	'addressFormat' => 'en',
	'thousands' => ',',
	'decimals' => '.',
];

$config['AutoLogin'] = [
	'active' => 1,
	'controller' => 'account',
	'username' => 'login',
	'debug' => 0,
];

$config['Validation'] = [
	//'autoRequire' => false,
	'browserAutoRequire' => false,
];

$config['Queue'] = [
	'workermaxruntime' => 40 * MINUTE,
	'sleeptime' => 20,
	'defaultworkertimeout' => 40 * MINUTE,
	'log' => true
];

$config['Search'] = [
	'Prg' => [
		'commonProcess' => ['paramType' => 'querystring', 'filterEmpty' => true],
		'presetForm' => ['paramType' => 'querystring']
	],
	'Searchable' => [],
];

$config['Country'] = [
	'imagePath' => 'Data./img/country_flags/',
];

$config['Select'] = [
	'defaultBefore' => ' -[ ',
	'defaultAfter' => ' ]- ',
	'naBefore' => ' -- ',
	'naAfter' => ' -- '
];
