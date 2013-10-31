<?php
Router::parseExtensions();

Router::connect('/', array('controller' => 'overview', 'action' => 'index'));

Router::connect('/register', array('controller' => 'account', 'action' => 'register'));
Router::connect('/login', array('controller' => 'account', 'action' => 'login'));
Router::connect('/logout', array('controller' => 'account', 'action' => 'logout'));

//route to switch locale
//Router::connect('/lang/*', array('controller' => 'p28n', 'action' => 'change'));

Router::connect('/admin', array('admin' => 'admin', 'controller' => 'overview', 'action' => 'index'));

//Router::connect('/translate', array('plugin' => 'translate', 'controller' => 'translate_groups', 'action' => 'overview'));

Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));

CakePlugin::routes();

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
require CAKE . 'Config' . DS . 'routes.php';
