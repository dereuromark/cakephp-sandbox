<?php
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\InternalErrorException;
use Cake\Network\Exception\NotFoundException;

class AccountController extends AppController {

	/**
	 * @var string
	 */
	public $modelClass = 'Users';

	/**
	 * @return \Cake\Network\Response|null
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
				$this->Flash->success(__('loggedInMessage'));

				return $this->redirect($this->Auth->redirectUrl());
			}
			$this->Flash->error('Wrong username/email or password');
			$this->request->data['password'] = '';
		} else {
			$username = $this->request->query('username');
			if ($username) {
				$this->request->data['login'] = $username;
			}
		}
	}

	/**
	 * @return \Cake\Network\Response|null
	 */
	public function logout() {
		$whereTo = $this->Auth->logout();
		# delete cookie
		if (Configure::read('Config.rememberMe')) {
			$this->Comon->loadComponent('Tools.RememberMe');
			$this->RememberMe->delete();
		}
		$this->Flash->success(__('loggedOutMessage'));
		return $this->redirect($whereTo);
	}

	/**
	 * @param string|null $key
	 * @return \Cake\Network\Response|null
	 */
	public function lostPassword($key = null) {
		if ($this->Common->isPosted()) {
			$keyToCheck = $this->request->data('Form.key');
		} elseif (!empty($key)) {
			$keyToCheck = $key;
		}

		if (!empty($keyToCheck)) {
			$this->Token = ClassRegistry::init('Tools.Token');
			$key = $this->Token->useKey('reset_pwd', $keyToCheck);

			if (!empty($key) && $key['Token']['used'] == 1) {
				$this->Flash->warning(__('alreadyChangedYourPassword'));
			} elseif (!empty($key)) {
				$uid = $key['Token']['user_id'];
				$this->Session->write('Auth.Tmp.id', $uid);
				return $this->redirect(['action' => 'change_password']);
			} else {
				$this->Flash->error(__('Invalid Key'));
			}
		} elseif (!empty($this->request->data['Form']['login'])) {
			//$this->Users->addBehavior('Tools.Captcha');
			unset($this->Users->validate['email']['isUnique']);
			$this->Users->set($this->request->data);

			// Validate basic email scheme and captcha input.
			if ($this->Users->validates()) {
				$res = $this->Users->find('first', [
					'fields' => ['username', 'id', 'email'],
					'conditions' => ['email' => $this->request->data['Form']['login']]]);

				// Valid user found to this email address
				if (!empty($res)) {
					$uid = $res['User']['id'];
					$this->Token = ClassRegistry::init('Tools.Token');
					$cCode = $this->Token->newKey('reset_pwd', null, $uid);
					if (Configure::read('debug') > 0) {
						$debugMessage = 'DEBUG MODE: Show activation key - ' . h($res['User']['username']) . ' | ' . $cCode;
						$this->Flash->info($debugMessage);
					}

					// Send email
					Configure::write('Email.live', true);

					$this->Email = new Email();
					$this->Email->to($res['User']['email'], $res['User']['username']);
					$this->Email->subject(Configure::read('Config.pageName') . ' - ' . __('Password request'));
					$this->Email->template('lost_password');
					$this->Email->viewVars(compact('cCode'));
					if ($this->Email->send()) {
						// Confirmation output

						$email = h(FormatHelper::hideEmail($res['User']['email']));

						$this->Flash->success(__('An email with instructions has been send to \'{0}\'.', $email));
						$this->Flash->success(__('In a third step you will then be able to change your password.'));
					} else {
						$this->Flash->error(__('Confirmation Email could not be sent. Please consult an admin.'));
					}
					return $this->redirect(['action' => 'lost_password']);
				}
				$this->Flash->error(__('No account has been found for \'{0}\'', $this->request->data['Form']['login']));
			}
		}

		$this->helpers = array_merge($this->helpers, ['Tools.Captcha']);
	}

	/**
	 * AccountController::change_password()
	 *
	 * @return \Cake\Network\Response|null
	 */
	public function changePassword() {
		$uid = $this->Session->read('Auth.Tmp.id');
		if (empty($uid)) {
			$this->Flash->error(__('You have to find your account first and click on the link in the email you receive afterwards'));
			return $this->redirect(['action' => 'lost_password']);
		}

		if ($this->request->query('abort')) {
			if (!empty($uid)) {
				$this->Session->delete('Auth.Tmp');
			}
			return $this->redirect(['action' => 'login']);
		}

		$user = $this->Users->newEntity();
		$this->Users->addBehavior('Tools.Passwordable', []);
		if ($this->Common->isPosted()) {
			$this->request->data['id'] = $uid;
			$user = $this->Users->patchEntity($user, $this->request->data);

			if ($this->Users->save($user, ['fieldList' => ['id', 'pwd', 'pwd_repeat']])) {
				$this->Flash->success(__('new pw saved - you may now log in'));
				$this->Session->delete('Auth.Tmp');
				$username = $this->Users->field('username', ['id' => $uid]);
				return $this->redirect(['action' => 'login', '?' => ['username' => $username]]);
			}
			$this->Flash->error(__('formContainsErrors'));

			// Pwd should not be passed to the view again for security reasons.
			unset($this->request->data['User']['pwd']);
			unset($this->request->data['User']['pwd_repeat']);
		}
	}

	/**
	 * @return \Cake\Network\Response|null
	 */
	public function register() {
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
	 * @return \Cake\Network\Response|null
	 */
	public function index() {
	}

	/**
	 * @return \Cake\Network\Response|null
	 */
	public function edit() {
		throw new NotFoundException();

		$uid = $this->Session->read('Auth.User.id');
		$user = $this->Users->get($uid);
		$this->Users->addBehavior('Tools.Passwordable', ['require' => false]);

		if ($this->Common->isPosted()) {
			$this->request->data['id'] = $uid;
			$fieldList = ['id', 'username', 'email', 'irc_nick', 'pwd', 'pwd_repeat'];
			$this->Users->patchEntity($user, $this->request->data, ['fieldList' => $fieldList]);
			if ($this->Users->save($user)) {
				$this->Flash->success(__('Account modified'));
				/*
				if (!$this->Auth->setUser($this->Users->get($uid))) {
					throw new \Exception('Cannot log user in');
				}
				*/
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
	 * @param mixed $id
	 * @return \Cake\Network\Response|null
	 */
	public function delete($id = null) {
		$this->request->allowMethod(['post', 'delete']);
		$uid = $this->Session->read('Auth.User.id');
		if (!$this->Users->delete($uid)) {
			throw new InternalErrorException();
		}
		$this->Flash->success('Account deleted');
		return $this->redirect(['action' => 'logout']);
	}

}
