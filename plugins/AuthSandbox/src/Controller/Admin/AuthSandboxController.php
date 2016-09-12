<?php
namespace AuthSandbox\Controller\Admin;

use AuthSandbox\Controller\AuthSandboxController as NormalAuthSandboxController;

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
	 *
	 * @return void
	 */
	public function myPublicOne() {
	}

}
