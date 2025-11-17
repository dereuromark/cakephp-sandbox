<?php
declare(strict_types=1);

namespace Sandbox\Test\TestCase\Controller;

use Shim\TestSuite\IntegrationTestCase;

/**
 * Sandbox\Controller\BouncerExamplesController Test Case
 */
class BouncerExamplesControllerTest extends IntegrationTestCase {

	/**
	 * @var array<string>
	 */
	protected array $fixtures = [
		'plugin.Sandbox.SandboxArticles',
	];

	/**
	 * setUp method
	 *
	 * @return void
	 */
	protected function setUp(): void {
		parent::setUp();
		$this->disableErrorHandlerMiddleware();
	}

	/**
	 * Test that the index action is routable and doesn't throw errors
	 *
	 * @return void
	 */
	public function testIndexIsRoutable() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'BouncerExamples', 'action' => 'index']);
		// Just assert we got a valid HTTP response (not 404/500)
		$responseCode = $this->_response->getStatusCode();
		$this->assertTrue(
			$responseCode >= 200 && $responseCode < 400,
			"Index action returned unexpected status code: {$responseCode}"
		);
	}

	/**
	 * Test add GET displays form
	 *
	 * @return void
	 */
	public function testAddGet() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'BouncerExamples', 'action' => 'add']);

		$this->assertResponseOk();
		$this->assertResponseContains('Submit New Article');
		$this->assertResponseContains('form');
	}

}
