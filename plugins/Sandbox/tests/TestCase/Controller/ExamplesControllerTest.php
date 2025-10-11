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

		$this->assertResponseCode(301);
	}

	/**
	 * @return void
	 */
	public function testParams() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Examples', 'action' => 'params']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testPhpBasicfunctions() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Examples', 'action' => 'phpBasicfunctions']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testPhpValidationfunctions() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Examples', 'action' => 'phpValidationfunctions']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
