<?php

namespace AuthSandbox\Test\TestCase\Controller;

use AuthSandbox\Controller\AuthSandboxController;
use Cake\ORM\TableRegistry;
use Tools\TestSuite\IntegrationTestCase;

/**
 * App\Controller\AuthSandboxController Test Case
 */
class AuthSandboxControllerTest extends IntegrationTestCase {

	public $fixtures = ['app.Users', 'app.Roles'];

	public function setUp() {
		parent::setUp();
	}

	public function tearDown() {
		parent::tearDown();

		TableRegistry::clear();
	}

	/**
	 * Test index method
	 *
	 * @return void
	 */
	public function testIndex() {
		$this->get(['plugin' => 'AuthSandbox', 'controller' => 'AuthSandbox', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * Test index method
	 *
	 * @return void
	 */
	public function testLogin() {
		$this->get(['plugin' => 'AuthSandbox', 'controller' => 'AuthSandbox', 'action' => 'login']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
