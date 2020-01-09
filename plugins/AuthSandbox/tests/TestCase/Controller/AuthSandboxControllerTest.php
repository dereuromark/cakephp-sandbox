<?php

namespace AuthSandbox\Test\TestCase\Controller;

use Tools\TestSuite\IntegrationTestCase;

/**
 * App\Controller\AuthSandboxController Test Case
 *
 * @uses \AuthSandbox\Controller\AuthSandboxController
 */
class AuthSandboxControllerTest extends IntegrationTestCase {

	/**
	 * @var array
	 */
	protected $fixtures = [
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

}
