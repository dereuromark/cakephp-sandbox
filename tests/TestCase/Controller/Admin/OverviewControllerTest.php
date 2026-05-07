<?php

namespace App\Test\TestCase\Controller\Admin;

use App\Test\Factory\RoleFactory;
use App\Test\Factory\UserFactory;
use Shim\TestSuite\IntegrationTestCase;

/**
 * App\Controller\Admin\OverviewController Test Case
 *
 * @uses \App\Controller\Admin\OverviewController
 */
class OverviewControllerTest extends IntegrationTestCase {

	/**
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();

		RoleFactory::seedAll();
		$user = UserFactory::new()->asSuperadmin()->build();
		$this->session(['Auth' => $user]);
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
