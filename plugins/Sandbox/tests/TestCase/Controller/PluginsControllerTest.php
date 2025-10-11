<?php

namespace Sandbox\Test\TestCase\Controller;

use Shim\TestSuite\IntegrationTestCase;

/**
 * @uses \Sandbox\Controller\ExamplesController
 * @uses \Sandbox\Controller\PluginsController
 */
class PluginsControllerTest extends IntegrationTestCase {

	/**
	 * @return void
	 */
	public function testMarkup() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Plugins', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testCakePdf() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Plugins', 'action' => 'cakePdf']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testIndex() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Plugins', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testPdfTest() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Plugins', 'action' => 'pdfTest']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
