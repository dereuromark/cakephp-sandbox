<?php

namespace AuthSandbox\Test\TestCase\Controller;

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
