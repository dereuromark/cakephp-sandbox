<?php
CakePlugin::loadAll();

Configure::load('configs'); // to define own parameters
Configure::load('configs_private'); // to define own non-version-controlled parameters
App::import('Lib', 'Tools.Bootstrap/MyBootstrap');

App::uses('Auth', 'Tools.Lib');

// see: http://nik.chankov.net/2007/12/20/using-different-date-format-in-cakephp-12/
Configure::write('DateBehaviour.dateFormat', 'dd.mm.yyyy');
Configure::write('DateBehaviour.delimiterDateFormat', '.');
Configure::write('DatePicker.format', '%d.%m.%Y');

define('WEBSERVICES', 'on');

define('PAGINATOR_SEPARATOR', ' | ');

define('ICON_ORDER', 'order.gif');