<?php

namespace App\Test\TestCase\Controller\Admin;

use Shim\TestSuite\IntegrationTestCase;

/**
 * App\Controller\Admin\UsersController Test Case
 *
 * @property \App\Model\Table\UsersTable $Users
 * @uses \App\Controller\Admin\UsersController
 */
class UsersControllerTest extends IntegrationTestCase {

	/**
	 * @var array<string>
	 */
	protected array $fixtures = [
		'app.Users',
		'app.Roles',
	];

	/**
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();

		$session = ['Auth' => ['User' => ['id' => 1, 'role_id' => 1]]];
		$this->session($session);
	}

	/**
	 * @return void
	 */
	public function testIndex() {
		$this->get(['prefix' => 'Admin', 'controller' => 'Users', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testAdd() {
		$this->get(['prefix' => 'Admin', 'controller' => 'Users', 'action' => 'add']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testEdit() {
		$this->get(['prefix' => 'Admin', 'controller' => 'Users', 'action' => 'edit', 1]);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
