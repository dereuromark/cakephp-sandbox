<?php

namespace Sandbox\Test\TestCase\Controller;

use Shim\TestSuite\IntegrationTestCase;

/**
 * @uses \Sandbox\Controller\CacheExamplesController
 */
class CacheExamplesControllerTest extends IntegrationTestCase {

	/**
	 * @return void
	 */
	public function testIndex() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'CacheExamples', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testMinute() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'CacheExamples', 'action' => 'minute']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testHour() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'CacheExamples', 'action' => 'hour']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testSomeJson() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'CacheExamples', 'action' => 'someJson', '_ext' => 'json']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
