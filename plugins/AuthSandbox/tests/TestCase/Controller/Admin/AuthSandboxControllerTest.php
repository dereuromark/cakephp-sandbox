<?php

namespace AuthSandbox\Test\TestCase\Controller\Admin;

use App\Test\Factory\RoleFactory;
use App\Test\Factory\UserFactory;
use Shim\TestSuite\IntegrationTestCase;

/**
 * App\Controller\AuthSandboxController Test Case
 *
 * @uses \AuthSandbox\Controller\Admin\AuthSandboxController
 */
class AuthSandboxControllerTest extends IntegrationTestCase {

	/**
	 * @return void
	 */
	protected function setUp(): void {
		parent::setUp();
		RoleFactory::seedAll();
	}

	/**
	 * @return void
	 */
	public function testIndex() {
		$this->disableErrorHandlerMiddleware();

		$user = UserFactory::new()->asAdmin()->save();
		$this->session(['Auth' => $user]);

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

		$user = UserFactory::new()->save();
		$this->session(['Auth' => $user]);

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
