<?php
App::uses('MyController', 'Tools.Controller');

/**
 * Application Controller
 */
class AppController extends MyController {

	public $components = array('Session', 'RequestHandler', 'Tools.Common', 'Auth');

	public $helpers = array('Session', 'Html', 'Form' => array('className' => 'Tools.FormExt'), 'Tools.Common', 'Tools.Format', 'Tools.Datetime', 'Tools.Numeric');

	/**
	 * AppController::constructClasses()
	 *
	 * @return void
	 */
	public function constructClasses() {
		if (CakePlugin::loaded('DebugKit')) {
			$this->components[] = 'DebugKit.Toolbar';
		}

		parent::constructClasses();
	}

	/**
	 * AppController::beforeFilter()
	 *
	 * @return void
	 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->authenticate = array(
			'Authenticate.MultiColumn' => array(
				'fields' => array(
					'username' => 'login',
					'password' => 'password'
				),
				'columns' => array('username', 'email'),
				'userModel' => 'User',
				//'scope' => array('User.email_confirmed' => 1)
			)
		);
		$this->Auth->authorize = array(
			'Tools.Tiny' => array()
		);
		$this->Auth->logoutRedirect = array(
			'plugin' => false,
			'admin' => false,
			'controller' => 'overview',
			'action' => 'index');
		$this->Auth->loginRedirect = array(
			'plugin' => false,
			'admin' => false,
			'controller' => 'account',
			'action' => 'index');
		$this->Auth->loginAction = array(
			'plugin' => false,
			'admin' => false,
			'controller' => 'account',
			'action' => 'login');

		$allowed = array('Account' => array('login', 'lost_password', 'register'));
		if (!Auth::id()) {
			return;
		}
		foreach ($allowed as $controller => $actions) {
			if ($this->name === $controller && in_array($this->request->action, $actions)) {
				$this->Common->flashMessage('The page you tried to access is not relevant if you are already logged in. Redirected to main page.', 'info');
				return $this->redirect($this->Auth->loginRedirect);
			}
		}
	}

	/**
	 * AppController::beforeRender()
	 *
	 * @return void
	 */
	public function beforeRender() {
		if ($this->request->is('ajax') && $this->layout === 'default') {
			$this->layout = 'ajax';
		}

		# default title
		if (empty($this->pageTitle)) {
			$this->pageTitle = __(Inflector::humanize($this->request->action)) . ' | ' . __($this->name);
		}
		$this->set('title_for_layout', $this->pageTitle);

		$this->disableCache();

		if ($m = $this->Session->read('Message.auth')) {
			$this->Common->flashMessage($m['message'], 'error');
			$this->Session->delete('Message.auth');
		}

		parent::beforeRender();
	}

}
