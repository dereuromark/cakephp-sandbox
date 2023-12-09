<?php

namespace Sandbox\Test\TestCase\Controller;

use Shim\TestSuite\IntegrationTestCase;

/**
 * @uses \Sandbox\Controller\ToolsExamplesController
 */
class ToolsExamplesControllerTest extends IntegrationTestCase {

	/**
	 * @var array
	 */
	protected array $fixtures = [
		'app.Users',
		'plugin.Sandbox.SandboxUsers',
		'plugin.Sandbox.SandboxAnimals',
	];

	/**
	 * @return void
	 */
	public function testIndex() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'ToolsExamples', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testSlug() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'ToolsExamples', 'action' => 'slug']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testPassword() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'ToolsExamples', 'action' => 'password']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testPasswordEdit() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'ToolsExamples', 'action' => 'passwordEdit']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testQr() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'ToolsExamples', 'action' => 'qr']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testGravatar() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'ToolsExamples', 'action' => 'gravatar']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testProgress() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'ToolsExamples', 'action' => 'progress']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testMeter() {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'ToolsExamples', 'action' => 'meter']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testBitmaskSearch() {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'ToolsExamples', 'action' => 'bitmaskSearch']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testBitmasks() {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'ToolsExamples', 'action' => 'bitmasks']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
