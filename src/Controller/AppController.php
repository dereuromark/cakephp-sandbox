<?php

namespace App\Controller;

use Cake\Event\EventInterface;
use Shim\Controller\RedirectOutOfBoundsTrait;
use Tools\Controller\Controller;

/**
 * @property \Flash\Controller\Component\FlashComponent $Flash
 * @property \Tools\Controller\Component\CommonComponent $Common
 * @property \TinyAuth\Controller\Component\AuthUserComponent $AuthUser
 * @property \TinyAuth\Controller\Component\AuthenticationComponent $Authentication
 * @property \TinyAuth\Controller\Component\AuthorizationComponent $Authorization
 */
class AppController extends Controller {

	use RedirectOutOfBoundsTrait;

	/**
	 * @return void
	 */
	public function initialize(): void {
		parent::initialize();

		$this->loadComponent('Tools.Common');
		$this->loadComponent('Flash.Flash');
		$this->loadComponent('TinyAuth.Authentication');
		$this->loadComponent('TinyAuth.Authorization');
		$this->loadComponent('TinyAuth.AuthUser');
	}

	/**
	 * @param \Cake\Event\EventInterface $event
	 *
	 * @return \Cake\Http\Response|null|void
	 */
	public function beforeFilter(EventInterface $event) {
		parent::beforeFilter($event);

		// Make sure you can't access login etc when already logged in
		$allowed = ['Account' => ['login', 'lostPassword', 'register']];
		if (!$this->AuthUser->id()) {
			return null;
		}

		foreach ($allowed as $controller => $actions) {
			if ($this->name === $controller && in_array($this->request->getParam('action'), $actions, true)) {
				//$this->Flash->info('The page you tried to access is not relevant if you are already logged in. Redirected to main page.');
				//return $this->redirect(['controller' => 'Account', 'action' => 'index']);
			}
		}
	}

	/**
	 * @param \Cake\Event\EventInterface $event
	 *
	 * @return \Cake\Http\Response|null|void
	 */
	public function beforeRender(EventInterface $event) {
		parent::beforeRender($event);

		$this->disableCache();
	}

}
