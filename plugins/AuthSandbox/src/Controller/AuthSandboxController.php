<?php

namespace AuthSandbox\Controller;

use App\Controller\AppController;
use Cake\Datasource\ModelAwareTrait;
use Cake\Event\EventInterface;

/**
 * @property \TinyAuth\Controller\Component\AuthComponent $Auth
 * @property \TinyAuth\Controller\Component\AuthUserComponent $AuthUser
 * @property \App\Model\Table\UsersTable $Users
 */
#[\AllowDynamicProperties]
class AuthSandboxController extends AppController {

	use ModelAwareTrait;

	/**
	 * @var int
	 */
	public const ROLE_USER = 4;

	/**
	 * @return void
	 */
	public function initialize(): void {
		parent::initialize();

		$this->loadComponent('TinyAuth.AuthUser');
		//$this->loadComponent('Security');

		$helpers = ['TinyAuth.AuthUser'];
		$this->viewBuilder()->addHelpers($helpers);

		$this->Users = $this->fetchTable('Users');
	}

	/**
	 * @param \Cake\Event\EventInterface $event
	 * @return \Cake\Http\Response|null|void
	 */
	public function beforeFilter(EventInterface $event) {
		parent::beforeFilter($event);

		$this->_authSetup();
	}

	/**
	 * @return void
	 */
	protected function _authSetup() {
		$this->Auth->setConfig('authenticate', [
			'TinyAuth.MultiColumn' => [
				'fields' => [
					'username' => 'login',
					'password' => 'password',
				],
				'columns' => ['username', 'email'],
				'userModel' => 'Users',
			],
		]);

		// Roles are defined in Roles table (and relationship linked in Users table)
		$this->Auth->setConfig('authorize', ['TinyAuth.Tiny']);

		$this->Auth->setConfig('loginAction', [
			'prefix' => false,
			'controller' => 'AuthSandbox',
			'action' => 'login',
			'plugin' => 'AuthSandbox',
		]);
		$this->Auth->setConfig('loginRedirect', [
			'prefix' => false,
			'controller' => 'AuthSandbox',
			'action' => 'index',
			'plugin' => 'AuthSandbox',
		]);
		$this->Auth->setConfig('logoutRedirect', [
			'prefix' => false,
			'controller' => 'AuthSandbox',
			'action' => 'login',
			'plugin' => 'AuthSandbox',
		]);
		$this->Auth->setConfig('authError', 'Did you really think you are allowed to see that?');
	}

	/**
	 * @return \Cake\Http\Response|null|void
	 */
	public function index() {
		if ($this->AuthUser->user('role_id')) {
			$role = $this->Users->Roles->get($this->AuthUser->user('role_id'));
			$this->set(compact('role'));
		}
	}

	/**
	 * @return \Cake\Http\Response|null|void
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
	 * @return \Cake\Http\Response|null|void
	 */
	public function register() {
		/** @var \App\Model\Entity\User $user */
		$user = $this->Users->newEmptyEntity();

		if ($this->request->is('post')) {
			$this->Users->addBehavior('Tools.Passwordable');

			$user->role_id = static::ROLE_USER;
			$user = $this->Users->patchEntity($user, $this->request->getData(), ['fields' => ['username']]);

			if ($this->Users->save($user)) {
				$this->Auth->setUser($user->toArray());
				$this->Flash->success('Registered and logged in :-)');

				return $this->redirect($this->Auth->redirectUrl());
			}

			$this->Flash->error(__('Please try again'));
		}

		$this->set(compact('user'));
	}

	/**
	 * @return \Cake\Http\Response|null
	 */
	public function logout() {
		return $this->redirect($this->Auth->logout());
	}

	/**
	 * Once you are logged in you can access this
	 *
	 * @return \Cake\Http\Response|null|void
	 */
	public function forAll() {
	}

	/**
	 * Only mods can access this
	 *
	 * @return \Cake\Http\Response|null|void
	 */
	public function forMods() {
	}

}
