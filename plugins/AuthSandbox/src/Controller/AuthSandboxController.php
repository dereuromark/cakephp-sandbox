<?php

namespace AuthSandbox\Controller;

use App\Controller\AppController;
use Cake\Event\EventInterface;

/**
 * @property \App\Model\Table\UsersTable $Users
 */
class AuthSandboxController extends AppController {

	/**
	 * @var int
	 */
	public const ROLE_USER = 4;

	/**
	 * @var string|null
	 */
	protected ?string $defaultTable = 'Users';

	/**
	 * @var \App\Model\Table\UsersTable
	 */
	protected $Users;

	/**
	 * @return void
	 */
	public function initialize(): void {
		parent::initialize();

		$this->loadComponent('TinyAuth.AuthUser');
		//$this->loadComponent('Security');

		$helpers = ['TinyAuth.AuthUser'];
		$this->viewBuilder()->addHelpers($helpers);

		$this->Users = $this->fetchTable();
	}

	/**
	 * @param \Cake\Event\EventInterface $event
	 * @return \Cake\Http\Response|null|void
	 */
	public function beforeFilter(EventInterface $event) {
		parent::beforeFilter($event);
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
		$result = $this->Authentication->getResult();
		// If the user is logged in send them away.
		if ($result && $result->isValid()) {
			$target = $this->Authentication->getLoginRedirect() ?? ['plugin' => 'AuthSandbox', 'controller' => 'AuthSandbox', 'action' => 'index'];

			return $this->redirect($target);
		}
		if ($this->request->is('post') && $result && !$result->isValid()) {
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

			$data = $this->request->getData();
			// Provide a default email based on username if not provided (for demo purposes)
			if (empty($data['email']) && !empty($data['username'])) {
				$data['email'] = $data['username'] . '@example.com';
			}

			$user->role_id = static::ROLE_USER;
			$user = $this->Users->patchEntity($user, $data, ['fields' => ['username', 'email', 'pwd', 'pwd_repeat']]);

			if ($this->Users->save($user)) {
				$this->Authentication->setIdentity($user);
				$this->Flash->success('Registered and logged in :-)');

				return $this->redirect(['plugin' => 'AuthSandbox', 'controller' => 'AuthSandbox', 'action' => 'index']);
			}

			$this->Flash->error(__('Please try again'));
		}

		$this->set(compact('user'));
	}

	/**
	 * @return \Cake\Http\Response|null
	 */
	public function logout() {
		$this->Authentication->logout();

		return $this->redirect(['plugin' => 'AuthSandbox', 'controller' => 'AuthSandbox', 'action' => 'login']);
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
