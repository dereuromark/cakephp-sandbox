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
	public function testMarkup() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Examples', 'action' => 'markup']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
