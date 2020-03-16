<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Event\EventInterface;
use Cake\Http\Exception\InternalErrorException;
use Cake\Http\Exception\NotFoundException;
use Cake\Mailer\Email;
use Tools\View\Helper\ObfuscateHelper;

/**
 * @property \App\Model\Table\UsersTable $Users
 * @property \Tools\Model\Table\TokensTable $Tokens
 */
class AccountController extends AppController {

	/**
	 * @var string
	 */
	protected $modelClass = 'Users';

	/**
	 * @param \Cake\Event\EventInterface $event
	 *
	 * @return \Cake\Http\Response|null|void
	 */
	public function beforeFilter(EventInterface $event) {
		parent::beforeFilter($event);

		if (Configure::read('debug')) {
			return null;
		}

		// Make sure people can't change the default users for security reasons
		$action = $this->request->getParam('action');
		$user = $this->AuthUser->user('username');
		if (in_array($action, ['edit', 'delete']) && in_array($user, ['user', 'mod', 'admin'])) {
			$this->Flash->warning('This user is for demo purposes and protected');
			return $this->redirect($this->referer(['action' => 'index']));
		}
	}

	/**
	 * @return \Cake\Http\Response|null|void
	 */
	public function login() {
		$userId = $this->Auth->user('id');
		if ($userId) {
			return $this->redirect($this->Auth->redirectUrl());
		}

		if ($this->Common->isPosted()) {
			$user = $this->Auth->identify();
			if ($user) {
				$this->Auth->setUser($user);
				$this->Flash->success(__('You are now logged in.'));

				return $this->redirect($this->Auth->redirectUrl());
			}
			$this->Flash->error('Wrong username/email or password');
			//$this->request->data['password'] = '';
		} else {
			$username = $this->request->getQuery('username');
			if ($username) {
				$this->request = $this->request->withData('login', $username);
			}
		}
	}

	/**
	 * @return \Cake\Http\Response|null
	 */
	public function logout() {
		$whereTo = $this->Auth->logout();

		$this->Flash->success(__('You are now logged out.'));

		return $this->redirect($whereTo);
	}

	/**
	 * @param string|null $key
	 * @return \Cake\Http\Response|null|void
	 * @throws \Cake\Http\Exception\NotFoundException
	 */
	public function lostPassword($key = null) {
		if (!Configure::read('debug')) {
			throw new NotFoundException('Disabled for live');
		}

		$user = $this->Users->newEmptyEntity();

		if ($this->Common->isPosted()) {
			$keyToCheck = $this->request->getData('Form.key');
		} elseif (!empty($key)) {
			$keyToCheck = $key;
		}

		if (!empty($keyToCheck)) {
			$this->loadModel('Tools.Tokens');
			$token = $this->Tokens->useKey('reset_pwd', $keyToCheck);

			if ($token && $token->used == 1) {
				$this->Flash->warning(__('alreadyChangedYourPassword'));
			} elseif ($token) {
				$uid = $token->user_id;
				$this->request->getSession()->write('Auth.Tmp.id', $uid);
				return $this->redirect(['action' => 'change_password']);
			}

			$this->Flash->error(__('Invalid Key'));

		} elseif ($this->request->getData('Form.login')) {
			//$this->Users->addBehavior('Tools.Captcha');
			unset($this->Users->validate['email']['isUnique']);
			//$this->Users->set($this->request->data);
			$data = $this->request->getData('Form');

			$user = $this->Users->patchEntity($user, $data);
			// Validate basic email scheme and captcha input.
			if (!$user->getErrors()) {
				/** @var \App\Model\Entity\User|null $res */
				$res = $this->Users->find('first', [
					'fields' => ['username', 'id', 'email'],
					'conditions' => [
						'email' => $this->request->getData('Form.login'),
					],
				]);

				// Valid user found to this email address
				if ($res) {
					$uid = $res->id;
					$this->loadModel('Tools.Tokens');
					$cCode = $this->Tokens->newKey('reset_pwd', null, $uid);
					if (Configure::read('debug') > 0) {
						$debugMessage = 'DEBUG MODE: Show activation key - ' . h($res->username) . ' | ' . $cCode;
						$this->Flash->info($debugMessage);
					}

					// Send email
					Configure::write('Email.live', true);

					$email = new Email();
					$email->setTo($res->email, $res->username);
					$email->setSubject(Configure::read('Config.pageName') . ' - ' . __('Password request'));
					$email->setTemplate('lost_password');
					$email->setViewVars(compact('cCode'));
					$email->send();

					$userEmail = h(ObfuscateHelper::hideEmail($res->email));

					$this->Flash->success(__('An email with instructions has been send to \'{0}\'.', $userEmail));
					$this->Flash->success(__('In a third step you will then be able to change your password.'));
					//$this->Flash->error(__('Confirmation Email could not be sent. Please consult an admin.'));

					return $this->redirect(['action' => 'lost_password']);
				}

				$this->Flash->error(__('No account has been found for \'{0}\'', $this->request->getData('Form.login')));
			}
		}

		//$this->helpers = array_merge($this->helpers, ['Tools.Captcha']);
		$this->set(compact('user'));
	}

	/**
	 * @return \Cake\Http\Response|null|void
	 * @throws \Cake\Http\Exception\NotFoundException
	 */
	public function changePassword() {
		if (!Configure::read('debug')) {
			throw new NotFoundException('Disabled for live');
		}

		$uid = $this->request->getSession()->read('Auth.Tmp.id');
		if (empty($uid)) {
			$this->Flash->error(__('You have to find your account first and click on the link in the email you receive afterwards'));
			return $this->redirect(['action' => 'lost_password']);
		}
		$user = $this->Users->get($uid);

		if ($this->request->getQuery('abort')) {
			if (!empty($uid)) {
				$this->request->getSession()->delete('Auth.Tmp');
			}

			return $this->redirect(['action' => 'login']);
		}

		$this->Users->addBehavior('Tools.Passwordable', []);
		if ($this->Common->isPosted()) {
			$user = $this->Users->patchEntity($user, $this->request->getData());

			if ($this->Users->save($user)) {
				$this->Flash->success(__('new pw saved - you may now log in'));
				$this->request->getSession()->delete('Auth.Tmp');
				$username = $this->Users->field('username', ['id' => $uid]);

				return $this->redirect(['action' => 'login', '?' => ['username' => $username]]);
			}
			$this->Flash->error(__('formContainsErrors'));

			// Pwd should not be passed to the view again for security reasons.
			//unset($this->request->data['pwd']);
			//unset($this->request->data['pwd_repeat']);
		}

		$this->set(compact('user'));
	}

	/**
	 * @return \Cake\Http\Response|null|void
	 */
	public function register() {
		if (!Configure::read('debug')) {
			throw new NotFoundException('Disabled for live');
		}

		$this->Users->addBehavior('Tools.Passwordable', []);

		$user = $this->Users->newEmptyEntity();
		if ($this->Common->isPosted()) {
			$data = $this->request->getData();
			$data['role_id'] = Configure::read('Role.user');
			$user = $this->Users->patchEntity($user, $data);
			if (!$user->getErrors()) {
				$this->Flash->success(__('Account created'));
				$this->Auth->setUser($user);
				return $this->redirect(['controller' => 'overview', 'action' => 'index']);
			}
			$this->Flash->error(__('formContainsErrors'));

			# pw should not be passed to the view again for security reasons
			//unset($this->request->data['pwd']);
			//unset($this->request->data['pwd_repeat']);
		}
	}

	/**
	 * @return \Cake\Http\Response|null|void
	 */
	public function index() {
	}

	/**
	 * @return \Cake\Http\Response|null|void
	 */
	public function edit() {
		$uid = $this->request->getSession()->read('Auth.User.id');
		$user = $this->Users->get($uid);
		$this->Users->addBehavior('Tools.Passwordable', ['require' => false]);

		if ($this->Common->isPosted()) {
			$fieldList = ['username', 'email', 'pwd', 'pwd_repeat'];
			$this->Users->patchEntity($user, $this->request->getData(), ['fields' => $fieldList]);
			if ($this->Users->save($user)) {
				$this->Flash->success(__('Account modified'));

				$this->Auth->setUser($this->Users->get($uid)->toArray());

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('formContainsErrors'));

			// Pwd should not be passed to the view again for security reasons.
			//unset($this->request->data['pwd']);
			//unset($this->request->data['pwd_repeat']);
		}

		$this->set(compact('user'));
	}

	/**
	 * @return \Cake\Http\Response|null|void
	 * @throws \Cake\Http\Exception\InternalErrorException
	 */
	public function delete() {
		$this->request->allowMethod(['post', 'delete']);
		$uid = $this->request->getSession()->read('Auth.User.id');

		$user = $this->Users->get($uid);
		if (!$this->Users->delete($user)) {
			throw new InternalErrorException('Cannot delete user');
		}

		$this->Flash->success('Account deleted');

		return $this->redirect(['action' => 'logout']);
	}

}
