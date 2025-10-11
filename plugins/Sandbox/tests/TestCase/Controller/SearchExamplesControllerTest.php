<?php

namespace Sandbox\Test\TestCase\Controller;

use Shim\TestSuite\IntegrationTestCase;

/**
 * @uses \Sandbox\Controller\SearchExamplesController
 */
class SearchExamplesControllerTest extends IntegrationTestCase {

	/**
	 * @var array<string>
	 */
	protected array $fixtures = [
		'plugin.Data.Countries',
		'plugin.Sandbox.SandboxProducts',
	];

	/**
	 * @return void
	 */
	public function testIndex() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'SearchExamples', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testEmptyValues() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'SearchExamples', 'action' => 'emptyValues']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testRange() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'SearchExamples', 'action' => 'range']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testTable() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'SearchExamples', 'action' => 'table']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
