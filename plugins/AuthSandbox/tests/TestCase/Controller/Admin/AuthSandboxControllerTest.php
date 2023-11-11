<?php

namespace AuthSandbox\Test\TestCase\Controller\Admin;

use Shim\TestSuite\IntegrationTestCase;

/**
 * App\Controller\AuthSandboxController Test Case
 *
 * @uses \AuthSandbox\Controller\Admin\AuthSandboxController
 */
class AuthSandboxControllerTest extends IntegrationTestCase {

	/**
	 * @var array
	 */
	protected array $fixtures = [
		'app.Users',
		'app.Roles',
	];

	/**
	 * @return void
	 */
	public function testIndex() {
		$this->disableErrorHandlerMiddleware();

		$this->session(['Auth' => ['User' => ['id' => 1, 'role_id' => 1]]]);
		$this->get(['prefix' => 'Admin', 'plugin' => 'AuthSandbox', 'controller' => 'AuthSandbox', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * Test index method
	 *
	 * @return void
	 */
	public function testIndexNotAuthenticated() {
		$this->disableErrorHandlerMiddleware();

		$this->get(['prefix' => 'Admin', 'plugin' => 'AuthSandbox', 'controller' => 'AuthSandbox', 'action' => 'index']);

		$this->assertResponseCode(302);
		$this->assertRedirect();
	}

	/**
	 * Test index method
	 *
	 * @return void
	 */
	public function testIndexNotAllowed() {
		$this->disableErrorHandlerMiddleware();

		$this->session(['Auth' => ['User' => ['id' => 1, 'role_id' => 4]]]);
		$this->get(['prefix' => 'Admin', 'plugin' => 'AuthSandbox', 'controller' => 'AuthSandbox', 'action' => 'index']);

		$this->assertResponseCode(302);
		$this->assertRedirect();
	}

	/**
	 * Test index method
	 *
	 * @return void
	 */
	public function testMyPublicOne() {
		$this->get(['prefix' => 'Admin', 'plugin' => 'AuthSandbox', 'controller' => 'AuthSandbox', 'action' => 'myPublicOne']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
