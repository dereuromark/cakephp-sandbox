<?php

namespace Sandbox\Test\TestCase\Controller;

use Shim\TestSuite\IntegrationTestCase;

/**
 * @uses \Sandbox\Controller\TwigExamplesController
 */
class TwigExamplesControllerTest extends IntegrationTestCase {

	/**
	 * @return void
	 */
	public function testIndex() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'TwigExamples', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testBasic() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'TwigExamples', 'action' => 'basic']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
