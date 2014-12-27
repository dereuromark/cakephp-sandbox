<?php
namespace Controller;
App::uses('FormatHelper', 'Tools.View/Helper');
App::uses('EmailLib', 'Tools.Lib');
App::uses('AppController', 'Controller');

class AccountController extends AppController {

	public $uses = array('User');

	public function beforeFilter() {
		parent::beforeFilter();

		$this->Auth->allow('login', 'logout', 'register', 'activate', 'lost_password', 'change_password');
	}

	/**
	 * AccountController::login()
	 *
	 * @return void
	 */
	public function login() {
		if ($this->Common->isPosted()) {
			if ($this->Auth->login()) {
				$this->Flash->message(__('loggedInMessage'), 'success');

				return $this->redirect($this->Auth->redirectUrl());
			}
			$this->request->data['User']['password'] = '';

		} else {
			if ($username = $this->request->query('username')) {
				$this->request->data['User']['login'] = $username;
			}
		}
	}

	/**
	 * AccountController::logout()
	 *
	 * @return void
	 */
	public function logout() {
		$whereTo = $this->Auth->logout();
		# delete cookie
		if (Configure::read('Config.rememberMe')) {
			$this->Comon->loadComponent('Tools.RememberMe');
			$this->RememberMe->delete();
		}
		$this->Flash->message(__('loggedOutMessage'), 'success');
		return $this->redirect($whereTo);
	}

	/**
	 * AccountController::lost_password()
	 *
	 * @param string $key
	 * @return void
	 */
	public function lost_password($key = null) {
		if ($this->Common->isPosted()) {
			$keyToCheck = $this->request->data('Form.key');
		} elseif (!empty($key)) {
			$keyToCheck = $key;
		}

		if (!empty($keyToCheck)) {
			$this->Token = ClassRegistry::init('Tools.Token');
			$key = $this->Token->useKey('reset_pwd', $keyToCheck);

			if (!empty($key) && $key['Token']['used'] == 1) {
				$this->Flash->message(__('alreadyChangedYourPassword'), 'warning');
			} elseif (!empty($key)) {
				$uid = $key['Token']['user_id'];
				$this->Session->write('Auth.Tmp.id', $uid);
				return $this->redirect(array('action' => 'change_password'));
			} else {
				$this->Flash->message(__('Invalid Key'), 'error');
			}

		} elseif (!empty($this->request->data['Form']['login'])) {
			$this->User->Behaviors->attach('Tools.Captcha');
			unset($this->User->validate['email']['isUnique']);
			$this->User->set($this->request->data);

			// Validate basic email scheme and captcha input.
			if ($this->User->validates()) {
				$res = $this->User->find('first', array(
					'fields' => array('username', 'id', 'email'),
					'conditions' => array('email' => $this->request->data['Form']['login'])));

				// Valid user found to this email address
				if (!empty($res)) {
					$uid = $res['User']['id'];
					$this->Token = ClassRegistry::init('Tools.Token');
					$cCode = $this->Token->newKey('reset_pwd', null, $uid);
					if (Configure::read('debug') > 0) {
						$debugMessage = 'DEBUG MODE: Show activation key - ' . h($res['User']['username']) . ' | ' . $cCode;
						$this->Flash->message($debugMessage, 'info');
					}

					// Send email
					Configure::write('Email.live', true);
					
					$this->Email = new EmailLib();
					$this->Email->to($res['User']['email'], $res['User']['username']);
					$this->Email->subject(Configure::read('Config.pageName') . ' - ' . __('Password request'));
					$this->Email->template('lost_password');
					$this->Email->viewVars(compact('cCode'));
					if ($this->Email->send()) {
						// Confirmation output
						
						$email = h(FormatHelper::hideEmail($res['User']['email']));

						$this->Flash->message(__('An email with instructions has been send to \'%s\'.', $email), 'success');
						$this->Flash->message(__('In a third step you will then be able to change your password.'), 'success');
					} else {
						$this->Flash->message(__('Confirmation Email could not be sent. Please consult an admin.'), 'error');
					}
					return $this->redirect(array('action' => 'lost_password'));
				}
				$this->Flash->message(__('No account has been found for \'%s\'', $this->request->data['Form']['login']), 'error');
			}
		}

		$this->helpers = array_merge($this->helpers, array('Tools.Captcha'));
	}

	/**
	 * AccountController::change_password()
	 *
	 * @return void
	 */
	public function change_password() {
		$uid = $this->Session->read('Auth.Tmp.id');
		if (empty($uid)) {
			$this->Flash->message(__('You have to find your account first and click on the link in the email you receive afterwards'), 'error');
			return $this->redirect(array('action' => 'lost_password'));
		}

		if ($this->request->query('abort')) {
			if (!empty($uid)) {
				$this->Session->delete('Auth.Tmp');
			}
			return $this->redirect(array('action' => 'login'));
		}

		$this->User->Behaviors->load('Tools.Passwordable', array());
		if ($this->Common->isPosted()) {
			$this->request->data['User']['id'] = $uid;
			if ($this->User->save($this->request->data, true, array('id', 'pwd', 'pwd_repeat'))) {
				$this->Flash->message(__('new pw saved - you may now log in'), 'success');
				$this->Session->delete('Auth.Tmp');
				$username = $this->User->field('username', array('id' => $uid));
				return $this->redirect(array('action' => 'login', '?' => array('username' => $username)));
			}
			$this->Flash->message(__('formContainsErrors'), 'error');

			// Pwd should not be passed to the view again for security reasons.
			unset($this->request->data['User']['pwd']);
			unset($this->request->data['User']['pwd_repeat']);
		}
	}

	/**
	 * AccountController::register()
	 *
	 * @return void
	 */
	public function register() {
		$this->User->Behaviors->load('Tools.Passwordable', array());
		if ($this->Common->isPosted()) {
			$this->request->data['User']['role_id'] = Configure::read('Role.user');
			if ($user = $this->User->save($this->request->data)) {
				$this->Flash->message(__('Account created'), 'success');
				if (!$this->Auth->login($user['User'])) {
					throw new CakeException('Cannot log user in');
				}
				return $this->redirect(array('controller' => 'overview', 'action' => 'index'));
			}
			$this->Flash->message(__('formContainsErrors'), 'error');

			# pw should not be passed to the view again for security reasons
			unset($this->request->data['User']['pwd']);
			unset($this->request->data['User']['pwd_repeat']);
		}
	}

	/**
	 * AccountController::index()
	 *
	 * @return void
	 */
	public function index() {
	}

	/**
	 * AccountController::edit()
	 *
	 * @return void
	 */
	public function edit() {
		$uid = $this->Session->read('Auth.User.id');
		$user = $this->User->get($uid);
		$this->User->Behaviors->attach('Tools.Passwordable', array('require' => false));

		if ($this->Common->isPosted()) {
			$this->request->data['User']['id'] = $uid;
			if ($this->User->save($this->request->data, true, array('id', 'username', 'email', 'irc_nick', 'pwd', 'pwd_repeat'))) {
				$this->Flash->message(__('Account modified'), 'success');
				if (!$this->Auth->login($user['User'])) {
					throw new CakeException('Cannot log user in');
				}
				return $this->redirect(array('action' => 'index'));
			}
			$this->Flash->message(__('formContainsErrors'), 'error');

			// Pwd should not be passed to the view again for security reasons.
			unset($this->request->data['User']['pwd']);
			unset($this->request->data['User']['pwd_repeat']);
		} else {
			$this->request->data = $user;
		}
	}

	/**
	 * AccountController::delete()
	 *
	 * @param mixed $id
	 * @return void
	 */
	public function delete($id = null) {
		$this->request->onlyAllow('post', 'delete');
		$uid = $this->Session->read('Auth.User.id');
		if (!$this->User->delete($uid)) {
			throw new InternalErrorException();
		}
		$this->Flash->message('Account deleted', 'success');
		return $this->redirect(array('action' => 'logout'));
	}

}
