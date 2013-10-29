<?php

$config['Debug'] = array(
	'helper' => 1,
	'check_for_cake_version' => 0, # gecached 24 hours :-)
	'check_for_php_version' => 0, # gecached 48 hours :-)
	'ajax_remember' => 1,	# ajax remember current tab
	'override' => 1 # if cache etc is usually disabled in debug mode, this overrides it
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

$config['Role'] = array(
	'admin' => '1',
	'user' => '2',
);

$config['App'] = array(
	'language' => 'eng',
);

$config['Asset'] = array(
	'js' => 'buffer'
);

$config['Cronjob'] = array(
	'code' => 'xyz',
	'www_active' => 1, # if cronjobs are possible from www (/cronjobs/run/)
);

$config['Config'] = array(
	'admin_name' => 'Site Owner',
	'admin_email' => 'test@test.de',
	'admin_emailname' => 'Site Owner',
	'no_reply_email' => 'noreply@test.de',
	'no_reply_emailname' => '',
	'max_emails' => '10',
	'page_name' => 'Sandbox',
	'domain_name' => 'CakePHP Sandbox',
	'keywords' => '',
	'description' => '',
	'author' => '',
	'flood_protection' => 60,		# seconds
	'bruteforce_trials' => 2,
	'bruteforce_interval' => 60,	# seconds
	//'max_login_trials' => 2,
	'secure_critical_actions' => 1,		# pw neccessary -> more security (change_pw, change_email, Account delete)
	'admin_appr_register' => 0,	# if user can access site right after activation
	'user_online_time' => 10,	# minutes
	'user_inactive_time' => 20,	# minutes
	'insert_ip' => 0,	# insert ips on login in users table
	'check_ip' => 0,	# trigger admin warning if different users sign in with the same ip
	'soft_delete'	=> 1,	# 1=UsernameIsDeleted, but UserRecord is not deleted
	'allow_register' => 0
);

$config['Twitter'] = array(
	'id' => '',
	'cache_duration' => ''
);
/** end: private information holder */

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

/** 0000 to 0777 Rights **/
$config['FolderRights'] = array(
		'locale' => '0777',
		'webroot' . DS . 'img' => '0777',
		'webroot' . DS . 'files' => '0777',
		'webroot' . DS . 'folder' => '0777',
	);

$config['Currency'] = array(
	'code' => 'EUR',
	'symbolLeft' => '€',
	'symbolRight' => '',
	'places' => '2',
	'thousands' => '.',
	'decimals' => ',',
);

$config['Localization'] = array(
	'address_format' => 'de',
	'thousands' => '.',
	'decimals' => ',',
);

