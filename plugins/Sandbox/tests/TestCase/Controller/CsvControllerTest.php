<?php

namespace Sandbox\Test\TestCase\Controller;

use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Tools\TestSuite\IntegrationTestCase;

class CsvControllerTest extends IntegrationTestCase {

	/**
	 * @var array
	 */
	public $fixtures = ['plugin.Data.Countries'];

	/**
	 * @return void
	 */
	public function setUp() {
		parent::setUp();

		Router::extensions(['csv']);
	}

	/**
	 * @return void
	 */
	public function tearDown() {
		parent::tearDown();

		TableRegistry::clear();
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

}
