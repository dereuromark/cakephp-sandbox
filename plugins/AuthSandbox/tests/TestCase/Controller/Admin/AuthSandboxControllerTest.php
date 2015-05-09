<?php

namespace AuthSandbox\Test\TestCase\Controller\Admin;

use AuthSandbox\Controller\Admin\AuthSandboxController;
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
		$this->session(['Auth' => ['User' => ['id' => 1, 'role_id' => 1]]]);
		$this->get(array('prefix' => 'admin', 'plugin' => 'AuthSandbox', 'controller' => 'AuthSandbox', 'action' => 'index'));

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * Test index method
	 *
	 * @return void
	 */
	public function testIndexNotAuthenticated() {
		$this->get(array('prefix' => 'admin', 'plugin' => 'AuthSandbox', 'controller' => 'AuthSandbox', 'action' => 'index'));

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
		$this->get(array('prefix' => 'admin', 'plugin' => 'AuthSandbox', 'controller' => 'AuthSandbox', 'action' => 'index'));

		$this->assertResponseCode(302);
		$this->assertRedirect();
	}

	/**
	 * Test index method
	 *
	 * @return void
	 */
	public function testMyPublicOne() {
		$this->get(array('prefix' => 'admin', 'plugin' => 'AuthSandbox', 'controller' => 'AuthSandbox', 'action' => 'myPublicOne'));

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
