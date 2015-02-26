<?php
namespace AuthSandbox\Controller\Admin;

use Cake\Event\Event;
use AuthSandbox\Controller\AuthSandboxController as NormalAuthSandboxController;
use Cake\Core\Configure;

class AuthSandboxController extends NormalAuthSandboxController {

	/**
	 * @return void
	 */
	protected function _allowActions() {
		$this->Auth->allow(['myPublicOne']);
	}

	/**
	 * Only admins can access this
	 *
	 * @return void
	 */
	public function index() {
	}

	/**
	 * A public method in the admin prefixed scope
	 */
	public function myPublicOne() {
	}

}
