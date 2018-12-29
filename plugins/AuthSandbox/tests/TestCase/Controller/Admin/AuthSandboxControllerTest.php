<?php

namespace AuthSandbox\Test\TestCase\Controller\Admin;

use Cake\ORM\TableRegistry;
use Tools\TestSuite\IntegrationTestCase;

/**
 * App\Controller\AuthSandboxController Test Case
 */
class AuthSandboxControllerTest extends IntegrationTestCase {

	/**
	 * @var array
	 */
	public $fixtures = [
		'app.Users',
		'app.Roles'
	];

	/**
	 * @return void
	 */
	public function setUp() {
		parent::setUp();
	}

	/**
	 * @return void
	 */
	public function tearDown() {
		parent::tearDown();

		TableRegistry::clear();
	}

	/**
	 * @return void
	 */
	public function testIndex() {
		$this->session(['Auth' => ['User' => ['id' => 1, 'role_id' => 1]]]);
		$this->get(['prefix' => 'admin', 'plugin' => 'AuthSandbox', 'controller' => 'AuthSandbox', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * Test index method
	 *
	 * @return void
	 */
	public function testIndexNotAuthenticated() {
		$this->get(['prefix' => 'admin', 'plugin' => 'AuthSandbox', 'controller' => 'AuthSandbox', 'action' => 'index']);

		$this->assertResponseCode(302);
		$this->assertRedirect();
	}

	/**
	 * Test index method
	 *
	 * @return void
	 */
	public function testIndexNotAllowed() {
		$this->session(['Auth' => ['User' => ['id' => 1, 'role_id' => 4]]]);
		$this->get(['prefix' => 'admin', 'plugin' => 'AuthSandbox', 'controller' => 'AuthSandbox', 'action' => 'index']);

		$this->assertResponseCode(302);
		$this->assertRedirect();
	}

	/**
	 * Test index method
	 *
	 * @return void
	 */
	public function testMyPublicOne() {
		$this->get(['prefix' => 'admin', 'plugin' => 'AuthSandbox', 'controller' => 'AuthSandbox', 'action' => 'myPublicOne']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
