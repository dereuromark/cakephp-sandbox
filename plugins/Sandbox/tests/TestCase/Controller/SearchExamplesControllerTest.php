<?php

namespace Sandbox\Test\TestCase\Controller;

use Shim\TestSuite\IntegrationTestCase;

/**
 * @uses \Sandbox\Controller\SearchExamplesController
 */
class SearchExamplesControllerTest extends IntegrationTestCase {

	/**
	 * @var array
	 */
	protected array $fixtures = [
		'plugin.Data.Countries',
	];

	/**
	 * @return void
	 */
	public function testIndex() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'SearchExamples', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
