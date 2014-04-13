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

$config['Passwordable'] = array(
	'authType' => 'Blowfish'
);

/** private information holder */
$config['Mail'] = array(
	'debug' => 0,	# 0=no,1=flashMessageAfterwards,2=fullDebug(noMailSent)
	'log' => 1,
	'useSmtp' => 1,
	'smtpPort' => 25,
	'smtpTimeout' => 20,
	'smtpHost' => '',
	'smtpUsername' => '',
	'smtpPassword' => '',
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
	'adminName' => 'Site Owner',
	'adminEmail' => 'test@test.de',
	'noReplyEmail' => 'noreply@test.de',
	'noReplyEmailname' => '',
	'keywords' => '',
	'description' => '',
);

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
	'addressFormat' => 'en',
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

$config['Country'] = array(
	'imagePath' => 'Data./img/country_flags/',
);

$config['Select'] = array(
	'defaultBefore' => ' -[ ',
	'defaultAfter' => ' ]- ',
	'naBefore' => ' -- ',
	'naAfter' => ' -- '
);