<?php

namespace AuthSandbox\Test\TestCase\Controller;

use Shim\TestSuite\IntegrationTestCase;

/**
 * App\Controller\AuthSandboxController Test Case
 *
 * @uses \AuthSandbox\Controller\AuthSandboxController
 */
class AuthSandboxControllerTest extends IntegrationTestCase {

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
	public function testIndex() {
		$this->get(['plugin' => 'AuthSandbox', 'controller' => 'AuthSandbox', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testLogin() {
		$this->get(['plugin' => 'AuthSandbox', 'controller' => 'AuthSandbox', 'action' => 'login']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testForAll() {
		$Users = $this->fetchTable('Users');
		$user = $Users->get(1);
		$this->session(['Auth' => $user]);

		$this->get(['plugin' => 'AuthSandbox', 'controller' => 'AuthSandbox', 'action' => 'forAll']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testForMods() {
		$Users = $this->fetchTable('Users');
		// Create a user with mod role (role_id = 3)
		$user = $Users->newEntity([
			'username' => 'testmod',
			'email' => 'testmod@example.com',
			'password' => 'password',
			'role_id' => 3,
		]);
		$Users->save($user);

		$this->session(['Auth' => $user]);

		$this->get(['plugin' => 'AuthSandbox', 'controller' => 'AuthSandbox', 'action' => 'forMods']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testRegister() {
		$this->get(['plugin' => 'AuthSandbox', 'controller' => 'AuthSandbox', 'action' => 'register']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testLogout() {
		$Users = $this->fetchTable('Users');
		$user = $Users->get(1);
		$this->session(['Auth' => $user]);

		$this->get(['plugin' => 'AuthSandbox', 'controller' => 'AuthSandbox', 'action' => 'logout']);

		$this->assertResponseCode(302);
	}

}
