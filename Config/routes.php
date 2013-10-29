<?php
Router::parseExtensions();

/**
* Here, we are connecting '/' (base path) to controller called 'Pages',
* its action called 'display', and we pass a param to select the view file
* to use (in this case, /app/views/pages/home.thtml)...
*/
Router::connect('/', array('controller' => 'overview', 'action' => 'index'));
/**
* ...and connect the rest of 'Pages' controller's urls.
* WHY NOT WORKING?
*/
Router::connect('/page/*', array('plugin' => 0, 'controller' => 'pages', 'action' => 'display'));

//Router::connect('/user/*', array('admin'=>false, 'controller' => 'users', 'action' => 'view'));

Router::connect('/register', array('controller' => 'account', 'action' => 'register'));
Router::connect('/login', array('controller' => 'account', 'action' => 'login'));
Router::connect('/logout', array('controller' => 'account', 'action' => 'logout'));

//route to switch locale
//Router::connect('/lang/*', array('controller' => 'p28n', 'action' => 'change'));

Router::connect('/admin', array('admin' => 'admin', 'controller' => 'overview', 'action' => 'index'));

//Router::connect('/translate', array('plugin' => 'translate', 'controller' => 'translate_groups', 'action' => 'overview'));

CakePlugin::routes();

/**
* Load the CakePHP default routes. Remove this if you do not want to use
* the built-in default routes.
*/
require CAKE . 'Config' . DS . 'routes.php';