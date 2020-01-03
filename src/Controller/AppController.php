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
	 * @var array
	 */
	protected $components = ['RequestHandler', 'Tools.Common',
		'Flash.Flash', 'TinyAuth.Auth', 'TinyAuth.AuthUser'];

	/**
	 * @var array
	 */
	protected $helpers = ['Tools.Html', 'Tools.Url',
		'Form' => [], // => ['className' => 'BootstrapUI.Form']
		'Tools.Common', 'Flash.Flash', 'Tools.Format',
		'Tools.Time', 'Tools.Number', 'TinyAuth.AuthUser', 'AssetCompress.AssetCompress',
		'Shim.Configure', 'Tools.Progress', 'Tools.Meter',
	];

	/**
	 * @return void
	 */
	protected function _mergeControllerVars() {
		parent::_mergeControllerVars();

		$this->helpers['Form'] += (array)Configure::read('FormConfig');
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
