<?php
declare(strict_types = 1);

namespace Sandbox\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * Sandbox\Controller\GeoExamplesController Test Case
 *
 * @uses \Sandbox\Controller\GeoExamplesController
 */
class GeoExamplesControllerTest extends TestCase {

	use IntegrationTestTrait;

	/**
	 * Fixtures
	 *
	 * @var array
	 */
	protected $fixtures = [
		'plugin.Data.Countries',
		'plugin.Data.States',
	];

	/**
	 * Test index method
	 *
	 * @return void
	 */
	public function testIndex(): void {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'GeoExamples', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * Test query method
	 *
	 * @return void
	 */
	public function testQuery(): void {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'GeoExamples', 'action' => 'query']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
