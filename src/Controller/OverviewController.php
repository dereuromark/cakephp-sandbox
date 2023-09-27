<?php

namespace App\Controller;

/**
 * Start page controller.
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class OverviewController extends AppController {

	/**
	 * @var string
	 */
	protected ?string $defaultTable = 'Users';

	/**
	 * @return void
	 */
	public function index() {
	}

}
