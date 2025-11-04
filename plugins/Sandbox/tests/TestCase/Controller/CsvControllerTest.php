<?php

namespace Sandbox\Test\TestCase\Controller;

use Cake\Routing\Router;
use Shim\TestSuite\IntegrationTestCase;

/**
 * @uses \Sandbox\Controller\CsvController
 */
class CsvControllerTest extends IntegrationTestCase {

	/**
	 * @var array<string>
	 */
	protected array $fixtures = [
		'plugin.Data.Countries',
	];

	/**
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();

		Router::extensions(['csv']);
	}

	/**
	 * @return void
	 */
	public function testIndex() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Csv', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testSimple() {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'Csv', 'action' => 'simple', '_ext' => 'csv']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testPagination() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Csv', 'action' => 'pagination']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testPaginationCsv() {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'Csv', 'action' => 'pagination', '_ext' => 'csv']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testPaginationCsvDownload() {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'Csv', 'action' => 'pagination', '_ext' => 'csv', '?' => ['download' => 1]]);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
