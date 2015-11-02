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
				'prefix' => false,
				'controller' => 'Overview',
				'action' => 'index'
			],
			'loginRedirect' => [
				'plugin' => false,
				'prefix' => false,
				'controller' => 'Account',
				'action' => 'index'
			],
			'loginAction' => [
				'plugin' => false,
				'prefix' => false,
				'controller' => 'Account',
				'action' => 'login'
			]
		];
		$this->Auth->config($config);

		// Short-circuit Auth for some controller
		if (in_array($this->request->params['controller'], ['Pages'])) {
			$this->Auth->allow();
		}

		// Make sure you can't access login etc when already logged in
		$allowed = ['Account' => ['login', 'lost_password', 'register']];
		if (!$this->AuthUser->id()) {
			return;
		}
		foreach ($allowed as $controller => $actions) {
			if ($this->name === $controller && in_array($this->request->action, $actions)) {
				$this->Flash->info('The page you tried to access is not relevant if you are already logged in. Redirected to main page.');
				return $this->redirect($this->Auth->config('loginRedirect'));
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
		if ($this->request->is('ajax') && $this->viewBuilder()->layout() === 'default') {
			$this->viewBuilder()->layout('ajax');
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
