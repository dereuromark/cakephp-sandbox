<?php

namespace App\Test\TestCase\Controller;

use Shim\TestSuite\IntegrationTestCase;

/**
 * OverviewControllerTest
 *
 * @uses \App\Controller\OverviewController
 */
class OverviewControllerTest extends IntegrationTestCase {

	/**
	 * Test index method
	 *
	 * @return void
	 */
	public function testIndex() {
		$this->get(['controller' => 'Overview', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
