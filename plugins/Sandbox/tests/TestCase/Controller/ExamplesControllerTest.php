<?php

namespace Sandbox\Test\TestCase\Controller;

use Shim\TestSuite\IntegrationTestCase;

/**
 * @uses \Sandbox\Controller\ExamplesController
 */
class ExamplesControllerTest extends IntegrationTestCase {

	/**
	 * @return void
	 */
	public function testIndex() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Examples', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testMessages() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Examples', 'action' => 'messages']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
