<?php
namespace AuthSandbox\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * @property \TinyAuth\Controller\Component\AuthComponent $Auth
 * @property \TinyAuth\Controller\Component\AuthUserComponent $AuthUser
 */
class AuthSandboxController extends AppController {

	public $components = ['TinyAuth.AuthUser'];

	public $helpers = ['TinyAuth.AuthUser'];

	/**
	 * @param \Cake\Event\Event $event
	 * @return void
	 */
	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);

		$this->_authSetup();
	}

	/**
	 * @return void
	 */
	protected function _authSetup() {
		$this->Auth->config('authenticate', [
			'FOC/Authenticate.MultiColumn' => [
				'fields' => [
					'username' => 'login',
					'password' => 'password'
				],
				'columns' => ['username', 'email'],
				'userModel' => 'Users'
			]
		]);

		// Roles are defined in Roles table (and relationship linked in Users table)
		$this->Auth->config('authorize', ['TinyAuth.Tiny']);

		$this->Auth->config('loginAction', [
			'prefix' => false,
			'controller' => 'AuthSandbox',
			'action' => 'login',
			'plugin' => 'AuthSandbox'
		]);
		$this->Auth->config('loginRedirect', [
			'prefix' => false,
			'controller' => 'AuthSandbox',
			'action' => 'index',
			'plugin' => 'AuthSandbox'
		]);
		$this->Auth->config('logoutRedirect', [
			'prefix' => false,
			'controller' => 'AuthSandbox',
			'action' => 'login',
			'plugin' => 'AuthSandbox'
		]);
		$this->Auth->config('authError', 'Did you really think you are allowed to see that?');
	}

	/**
	 * @return \Cake\Network\Response|null
	 */
	public function index() {
	}

	/**
	 * @return \Cake\Network\Response|null
	 */
	public function login() {
		if ($this->request->is('post')) {
			$user = $this->Auth->identify();
			if ($user) {
				$this->Auth->setUser($user);
				return $this->redirect($this->Auth->redirectUrl());
			}
			$this->Flash->error(__('Username or password is incorrect'));
		}
	}

	/**
	 * @return \Cake\Network\Response|null
	 */
	public function logout() {
		return $this->redirect($this->Auth->logout());
	}

	/**
	 * Once you are logged in you can access this
	 *
	 * @return \Cake\Network\Response|null
	 */
	public function forAll() {
	}

	/**
	 * Only mods can access this
	 *
	 * @return \Cake\Network\Response|null
	 */
	public function forMods() {
	}

}
