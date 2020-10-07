<?php

namespace StateMachineSandbox\Controller;

use App\Controller\AppController;

/**
 * @property \App\Model\Table\UsersTable $Users
 */
class StateMachineSandboxController extends AppController {

	/**
	 * @var string
	 */
	protected $modelClass = 'Users';

	/**
	 * @return \Cake\Http\Response|null|void
	 */
	public function index() {
	}

}
