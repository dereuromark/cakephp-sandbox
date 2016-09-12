<?php
namespace App\Controller;

use Cake\Event\Event;
use Tools\Controller\Controller;

/**
 * Application Controller
 */
class AppController extends Controller {

	/**
	 * @var array
	 */
	public $components = ['Shim.Session', 'RequestHandler', 'Tools.Common',
		'Tools.Flash', 'TinyAuth.Auth', 'Tools.AuthUser'];

	/**
	 * @var array
	 */
	public $helpers = ['Shim.Session', 'Tools.Html', 'Tools.Url',
		'Tools.Form', 'Tools.Common', 'Tools.Flash', 'Tools.Format',
		'Tools.Time', 'Tools.Number', 'Tools.AuthUser', 'AssetCompress.AssetCompress'];

	/**
	 * @return void
	 */
	public function initialize() {
		parent::initialize();
	}

	/**
	 * @param \Cake\Event\Event $event
	 *
	 * @return \Cake\Network\Response|null
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

		// Make sure you can't access login etc when already logged in
		$allowed = ['Account' => ['login', 'lost_password', 'register']];
		if (!$this->AuthUser->id()) {
			return null;
		}

		foreach ($allowed as $controller => $actions) {
			if ($this->name === $controller && in_array($this->request->action, $actions)) {
				$this->Flash->info('The page you tried to access is not relevant if you are already logged in. Redirected to main page.');
				return $this->redirect($this->Auth->config('loginRedirect'));
			}
		}
	}

	/**
	 * @param \Cake\Event\Event $event
	 *
	 * @return \Cake\Network\Response|null
	 */
	public function beforeRender(Event $event) {
		parent::beforeRender($event);

		$this->disableCache();
	}

}
