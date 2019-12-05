<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Http\Exception\InternalErrorException;
use Cake\Http\Exception\NotFoundException;
use Tools\Mailer\Email;
use Tools\View\Helper\ObfuscateHelper;

/**
 * @property \App\Model\Table\UsersTable $Users
 * @property \Tools\Model\Table\TokensTable $Tokens
 */
class AccountController extends AppController {

	/**
	 * @var string
	 */
	public $modelClass = 'Users';

	/**
	 * @param \Cake\Event\Event $event
	 *
	 * @return \Cake\Http\Response|null
	 */
	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);

		if (Configure::read('debug')) {
			return null;
		}

		// Make sure people can't change the default users for security reasons
		$action = $this->request->param('action');
		$user = $this->AuthUser->user('username');
		if (in_array($action, ['edit', 'delete']) && in_array($user, ['user', 'mod', 'admin'])) {
			$this->Flash->warning('This user is for demo purposes and protected');
			return $this->redirect($this->referer(['action' => 'index']));
		}
	}

	/**
	 * @return \Cake\Http\Response|null
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
			$this->request->data['password'] = '';
		} else {
			$username = $this->request->getQuery('username');
			if ($username) {
				$this->request->data['login'] = $username;
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
	 * @return \Cake\Http\Response|null
	 * @throws \Cake\Http\Exception\NotFoundException
	 */
	public function lostPassword($key = null) {
		if (!Configure::read('debug')) {
			throw new NotFoundException('Disabled for live');
		}

		$user = $this->Users->newEmptyEntity();

		if ($this->Common->isPosted()) {
			$keyToCheck = $this->request->data('Form.key');
		} elseif (!empty($key)) {
			$keyToCheck = $key;
		}

		if (!empty($keyToCheck)) {
			$this->loadModel('Tools.Tokens');
			$key = $this->Tokens->useKey('reset_pwd', $keyToCheck);

			if (!empty($key) && $key['used'] == 1) {
				$this->Flash->warning(__('alreadyChangedYourPassword'));
			} elseif (!empty($key)) {
				$uid = $key['user_id'];
				$this->request->session()->write('Auth.Tmp.id', $uid);
				return $this->redirect(['action' => 'change_password']);
			} else {
				$this->Flash->error(__('Invalid Key'));
			}
		} elseif (!empty($this->request->data['Form']['login'])) {
			//$this->Users->addBehavior('Tools.Captcha');
			unset($this->Users->validate['email']['isUnique']);
			//$this->Users->set($this->request->data);

			// Validate basic email scheme and captcha input.
			if ($this->Users->validates()) {
				$res = $this->Users->find('first', [
					'fields' => ['username', 'id', 'email'],
					'conditions' => ['email' => $this->request->data['Form']['login']]]);

				// Valid user found to this email address
				if (!empty($res)) {
					$uid = $res['User']['id'];
					$this->loadModel('Tools.Tokens');
					$cCode = $this->Tokens->newKey('reset_pwd', null, $uid);
					if (Configure::read('debug') > 0) {
						$debugMessage = 'DEBUG MODE: Show activation key - ' . h($res['User']['username']) . ' | ' . $cCode;
						$this->Flash->info($debugMessage);
					}

					// Send email
					Configure::write('Email.live', true);

					$email = new Email();
					$email->to($res['User']['email'], $res['User']['username']);
					$email->subject(Configure::read('Config.pageName') . ' - ' . __('Password request'));
					$email->template('lost_password');
					$email->viewVars(compact('cCode'));
					if ($email->send()) {
						$userEmail = h(ObfuscateHelper::hideEmail($res['User']['email']));

						$this->Flash->success(__('An email with instructions has been send to \'{0}\'.', $userEmail));
						$this->Flash->success(__('In a third step you will then be able to change your password.'));
					} else {
						$this->Flash->error(__('Confirmation Email could not be sent. Please consult an admin.'));
					}
					return $this->redirect(['action' => 'lost_password']);
				}
				$this->Flash->error(__('No account has been found for \'{0}\'', $this->request->data['Form']['login']));
			}
		}

		//$this->helpers = array_merge($this->helpers, ['Tools.Captcha']);
		$this->set(compact('user'));
	}

	/**
	 * @return \Cake\Http\Response|null
	 * @throws \Cake\Http\Exception\NotFoundException
	 */
	public function changePassword() {
		if (!Configure::read('debug')) {
			throw new NotFoundException('Disabled for live');
		}

		$uid = $this->request->session()->read('Auth.Tmp.id');
		if (empty($uid)) {
			$this->Flash->error(__('You have to find your account first and click on the link in the email you receive afterwards'));
			return $this->redirect(['action' => 'lost_password']);
		}
		$user = $this->Users->get($uid);

		if ($this->request->getQuery('abort')) {
			if (!empty($uid)) {
				$this->request->session()->delete('Auth.Tmp');
			}
			return $this->redirect(['action' => 'login']);
		}

		$this->Users->addBehavior('Tools.Passwordable', []);
		if ($this->Common->isPosted()) {
			$user = $this->Users->patchEntity($user, $this->request->getData(), ['fields' => ['pwd', 'pwd_repeat']]);

			if ($this->Users->save($user)) {
				$this->Flash->success(__('new pw saved - you may now log in'));
				$this->request->session()->delete('Auth.Tmp');
				$username = $this->Users->field('username', ['id' => $uid]);
				return $this->redirect(['action' => 'login', '?' => ['username' => $username]]);
			}
			$this->Flash->error(__('formContainsErrors'));

			// Pwd should not be passed to the view again for security reasons.
			unset($this->request->data['pwd']);
			unset($this->request->data['pwd_repeat']);
		}

		$this->set(compact('user'));
	}

	/**
	 * @return \Cake\Http\Response|null
	 */
	public function register() {
		if (!Configure::read('debug')) {
			throw new NotFoundException('Disabled for live');
		}

		$this->Users->addBehavior('Tools.Passwordable', []);

		if ($this->Common->isPosted()) {
			$this->request->data['User']['role_id'] = Configure::read('Role.user');
			$user = $this->Users->save($this->request->data);
			if ($user) {
				$this->Flash->success(__('Account created'));
				$this->Auth->setUser($user['User']);
				return $this->redirect(['controller' => 'overview', 'action' => 'index']);
			}
			$this->Flash->error(__('formContainsErrors'));

			# pw should not be passed to the view again for security reasons
			unset($this->request->data['User']['pwd']);
			unset($this->request->data['User']['pwd_repeat']);
		}
	}

	/**
	 * @return \Cake\Http\Response|null
	 */
	public function index() {
	}

	/**
	 * @return \Cake\Http\Response|null
	 */
	public function edit() {
		$uid = $this->request->session()->read('Auth.User.id');
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
			unset($this->request->data['pwd']);
			unset($this->request->data['pwd_repeat']);
		}

		$this->set(compact('user'));
	}

	/**
	 * @return \Cake\Http\Response|null
	 * @throws \Cake\Http\Exception\InternalErrorException
	 */
	public function delete() {
		$this->request->allowMethod(['post', 'delete']);
		$uid = $this->request->session()->read('Auth.User.id');
		if (!$this->Users->delete($uid)) {
			throw new InternalErrorException('Cannot delete user');
		}
		$this->Flash->success('Account deleted');
		return $this->redirect(['action' => 'logout']);
	}

}
