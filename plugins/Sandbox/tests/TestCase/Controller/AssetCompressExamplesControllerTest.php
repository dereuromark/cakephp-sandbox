<?php

namespace Sandbox\Test\TestCase\Controller;

use Shim\TestSuite\IntegrationTestCase;

/**
 * @uses \Sandbox\Controller\AssetCompressExamplesController
 */
class AssetCompressExamplesControllerTest extends IntegrationTestCase {

	/**
	 * @return void
	 */
	public function testIndex() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'AssetCompressExamples', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testSass() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'AssetCompressExamples', 'action' => 'sass']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
