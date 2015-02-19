<?php
namespace AuthSandbox\Controller\Admin;

use Cake\Event\Event;
use AuthSandbox\Controller\AuthSandboxController as NormalAuthSandboxController;
use Cake\Core\Configure;

class AuthSandboxController extends NormalAuthSandboxController {

	/**
	 * Only admins can access this
	 *
	 * @return void
	 */
	public function index() {
	}

}
