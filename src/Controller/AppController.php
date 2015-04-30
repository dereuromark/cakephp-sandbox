<?php
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Event\Event;
use Cake\Utility\Inflector;
use Tools\Controller\Controller;

/**
 * Application Controller
 */
class AppController extends Controller {

	public $components = ['Shim.Session', 'RequestHandler', 'Tools.Common',
		'Tools.Flash', 'Auth', 'Tools.AuthUser'];

	public $helpers = ['Shim.Session', 'Tools.Html', 'Tools.Url',
		'Tools.Form', 'Tools.Common', 'Tools.Flash', 'Tools.Format',
		'Tools.Time', 'Tools.Number', 'Tools.AuthUser', 'AssetCompress.AssetCompress'];

	/**
	 * AppController::constructClasses()
	 *
	 * @return void
	 */
	public function initialize() {
		parent::initialize();
	}

	/**
	 * AppController::beforeFilter()
	 *
	 * @return void
	 */
	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);

		$config = [
			'authenticate' => [
				'FOC/Authenticate.MultiColumn' => [
					//'passwordHasher' => 'Default',
					'fields' => [
						'username' => 'login',
						'password' => 'password'
					],
					'columns' => ['username', 'email'],
					'userModel' => 'Users',
				]
			],
			'authorize' => ['TinyAuth.Tiny' => []],
			'logoutRedirect' => [
				'plugin' => false,
				'admin' => false,
				'controller' => 'Overview',
				'action' => 'index'
			],
			'loginRedirect' => [
				'plugin' => false,
				'admin' => false,
				'controller' => 'Account',
				'action' => 'index'
			],
			'loginAction' => [
				'plugin' => false,
				'admin' => false,
				'controller' => 'Account',
				'action' => 'login'
			]
		];
		$this->Auth->config($config);

		// Short-cicuit Auth for some controllers
		if (in_array($this->viewPath, ['Pages'])) {
			$this->Auth->allow();
		}

		// Make sure you can't access login etc when already logged in
		$allowed = ['Account' => ['login', 'lost_password', 'register']];
		if (!$this->AuthUser->id()) {
			return;
		}
		foreach ($allowed as $controller => $actions) {
			if ($this->name === $controller && in_array($this->request->action, $actions)) {
				$this->Flash->message('The page you tried to access is not relevant if you are already logged in. Redirected to main page.', 'info');
				return $this->redirect($this->Auth->loginRedirect);
			}
		}
	}

	/**
	 * AppController::beforeRender()
	 *
	 * @return void
	 */
	public function beforeRender(Event $event) {
		/*
		if ($this->request->is('ajax') && $this->layout === 'default') {
			$this->layout = 'ajax';
		}
		*/

		// default title
		/*
		if (empty($this->pageTitle)) {
			$this->pageTitle = __(Inflector::humanize($this->request->action)) . ' | ' . __($this->name);
		}

		$this->set('title_for_layout', $this->pageTitle);
		*/

		$this->disableCache();

		parent::beforeRender($event);
	}

}
