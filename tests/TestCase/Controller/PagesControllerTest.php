<?php

namespace App\Test\TestCase\Controller;

use Shim\TestSuite\IntegrationTestCase;

/**
 * @uses \App\Controller\PagesController
 */
class PagesControllerTest extends IntegrationTestCase {

	/**
	 * Test index method
	 *
	 * @return void
	 */
	public function testDisplay() {
		$this->get(['controller' => 'Pages', 'action' => 'display', 'best-practices']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
