<?php

namespace Sandbox\Test\TestCase\Controller;

use Cake\Routing\Router;
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
	public function setUp(): void {
		parent::setUp();

		Router::extensions(['json', 'xml']);
	}

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

	/**
	 * @return void
	 */
	public function testValidationGet() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'SearchExamples', 'action' => 'validation']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testValidationPostValid() {
		$this->post(
			['plugin' => 'Sandbox', 'controller' => 'SearchExamples', 'action' => 'validation'],
			['search' => 'Germany'],
		);

		$this->assertResponseCode(302);
		$this->assertRedirect(['plugin' => 'Sandbox', 'controller' => 'SearchExamples', 'action' => 'validation', '?' => ['search' => 'Germany']]);
	}

	/**
	 * @return void
	 */
	public function testValidationPostInvalid() {
		$this->post(
			['plugin' => 'Sandbox', 'controller' => 'SearchExamples', 'action' => 'validation'],
			['search' => 'ab'],
		);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
		$this->assertResponseContains('Search term must be at least 3 characters long');
	}

	/**
	 * @return void
	 */
	public function testValidationPostEmpty() {
		$this->post(
			['plugin' => 'Sandbox', 'controller' => 'SearchExamples', 'action' => 'validation'],
			['search' => ''],
		);

		$this->assertResponseCode(302);
		$this->assertRedirect(['plugin' => 'Sandbox', 'controller' => 'SearchExamples', 'action' => 'validation', '?' => []]);
	}

	/**
	 * @return void
	 */
	public function testValidationPostInactiveStatusInvalid() {
		$this->post(
			['plugin' => 'Sandbox', 'controller' => 'SearchExamples', 'action' => 'validation'],
			['status' => '0'],
		);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
		$this->assertResponseContains('You can only search for active ones today');
	}

	/**
	 * @return void
	 */
	public function testValidationPostActiveStatusValid() {
		$this->post(
			['plugin' => 'Sandbox', 'controller' => 'SearchExamples', 'action' => 'validation'],
			['status' => '1'],
		);

		$this->assertResponseCode(302);
		$this->assertRedirect(['plugin' => 'Sandbox', 'controller' => 'SearchExamples', 'action' => 'validation', '?' => ['status' => '1']]);
	}

	/**
	 * @return void
	 */
	public function testTableJson() {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'SearchExamples', 'action' => 'table', '_ext' => 'json']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testTableXml() {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'SearchExamples', 'action' => 'table', '_ext' => 'xml']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
