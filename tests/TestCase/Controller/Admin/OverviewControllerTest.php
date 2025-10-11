<?php

namespace App\Test\TestCase\Controller\Admin;

use Shim\TestSuite\IntegrationTestCase;

/**
 * App\Controller\Admin\OverviewController Test Case
 *
 * @uses \App\Controller\Admin\OverviewController
 */
class OverviewControllerTest extends IntegrationTestCase {

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
		$this->get(['prefix' => 'Admin', 'controller' => 'Overview', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
