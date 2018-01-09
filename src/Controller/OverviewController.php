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
	public $modelClass = 'Users';

	/**
	 * @return void
	 */
	public function index() {
	}

}
