<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Event\EventInterface;
use Tools\Controller\Controller;

/**
 * @property \Flash\Controller\Component\FlashComponent $Flash
 * @property \Tools\Controller\Component\CommonComponent $Common
 * @property \TinyAuth\Controller\Component\AuthUserComponent $AuthUser
 * @property \TinyAuth\Controller\Component\AuthComponent $Auth
 */
class AppController extends Controller {

	/**
	 * @return void
	 */
	public function initialize(): void {
		parent::initialize();

		$this->loadComponent('RequestHandler');
		$this->loadComponent('Tools.Common');
		$this->loadComponent('Flash.Flash');
		$this->loadComponent('TinyAuth.Auth');
		$this->loadComponent('TinyAuth.AuthUser');

		$helpers = [
			'Tools.Html',
			'Tools.Url',
			'Form' => (array)Configure::read('FormConfig'), // => ['className' => 'BootstrapUI.Form']
			'Tools.Common',
			'Flash.Flash',
			'Tools.Format',
			'Tools.Time',
			'Tools.Number',
			'TinyAuth.AuthUser',
			'AssetCompress.AssetCompress',
			'Shim.Configure',
			'Tools.Progress',
			'Tools.Meter',
		];
		$this->viewBuilder()->setHelpers($helpers);
	}

	/**
	 * @param \Cake\Event\EventInterface $event
	 *
	 * @return \Cake\Http\Response|null
	 */
	public function beforeFilter(EventInterface $event) {
		parent::beforeFilter($event);

		$config = [
			'authenticate' => [
				'Tools.MultiColumn' => [
					'fields' => [
						'username' => 'login',
						'password' => 'password',
					],
					'columns' => ['username', 'email'],
					'userModel' => 'Users',
				],
			],
			'authorize' => ['TinyAuth.Tiny' => []],
			'logoutRedirect' => [
				'plugin' => false,
				'prefix' => false,
				'controller' => 'Overview',
				'action' => 'index',
			],
			'loginRedirect' => [
				'plugin' => false,
				'prefix' => false,
				'controller' => 'Account',
				'action' => 'index',
			],
			'loginAction' => [
				'plugin' => false,
				'prefix' => false,
				'controller' => 'Account',
				'action' => 'login',
			],
		];
		$this->Auth->setConfig($config);

		// Make sure you can't access login etc when already logged in
		$allowed = ['Account' => ['login', 'lost_password', 'register']];
		if (!$this->AuthUser->id()) {
			return null;
		}

		foreach ($allowed as $controller => $actions) {
			if ($this->name === $controller && in_array($this->request->param('action'), $actions)) {
				$this->Flash->info('The page you tried to access is not relevant if you are already logged in. Redirected to main page.');
				return $this->redirect($this->Auth->setConfig('loginRedirect'));
			}
		}
	}

	/**
	 * @param \Cake\Event\EventInterface $event
	 *
	 * @return \Cake\Http\Response|null
	 */
	public function beforeRender(EventInterface $event) {
		parent::beforeRender($event);

		$this->disableCache();
	}

}
