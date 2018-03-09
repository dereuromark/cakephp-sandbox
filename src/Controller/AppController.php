<?php
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Event\Event;
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
	public $components = ['RequestHandler', 'Tools.Common',
		'Flash.Flash', 'TinyAuth.Auth', 'TinyAuth.AuthUser'];

	/**
	 * @var array
	 */
	public $helpers = ['Tools.Html', 'Tools.Url',
		'Form' => ['className' => 'BootstrapUI.Form'],
		'Tools.Common', 'Flash.Flash', 'Tools.Format',
		'Tools.Time', 'Tools.Number', 'TinyAuth.AuthUser', 'AssetCompress.AssetCompress',
		'Shim.Configure',
	];

	/**
	 * @return void
	 */
	protected function _mergeControllerVars() {
		parent::_mergeControllerVars();

		$this->helpers['Form'] += (array)Configure::read('FormConfig');
	}

	/**
	 * @param \Cake\Event\Event $event
	 *
	 * @return \Cake\Http\Response|null
	 */
	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);

		$config = [
			'authenticate' => [
				'Tools.MultiColumn' => [
					'fields' => [
						'username' => 'login',
						'password' => 'password'
					],
					'columns' => ['username', 'email'],
					'userModel' => 'Users',
				]
			],
			'authorize' => ['TinyAuth.Tiny' => []],
			'logoutRedirect' => [
				'plugin' => false,
				'prefix' => false,
				'controller' => 'Overview',
				'action' => 'index'
			],
			'loginRedirect' => [
				'plugin' => false,
				'prefix' => false,
				'controller' => 'Account',
				'action' => 'index'
			],
			'loginAction' => [
				'plugin' => false,
				'prefix' => false,
				'controller' => 'Account',
				'action' => 'login'
			]
		];
		$this->Auth->config($config);

		// Make sure you can't access login etc when already logged in
		$allowed = ['Account' => ['login', 'lost_password', 'register']];
		if (!$this->AuthUser->id()) {
			return null;
		}

		foreach ($allowed as $controller => $actions) {
			if ($this->name === $controller && in_array($this->request->param('action'), $actions)) {
				$this->Flash->info('The page you tried to access is not relevant if you are already logged in. Redirected to main page.');
				return $this->redirect($this->Auth->config('loginRedirect'));
			}
		}
	}

	/**
	 * @param \Cake\Event\Event $event
	 *
	 * @return \Cake\Http\Response|null
	 */
	public function beforeRender(Event $event) {
		parent::beforeRender($event);

		$this->disableCache();
	}

}
