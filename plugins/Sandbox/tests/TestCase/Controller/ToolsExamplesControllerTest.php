<?php

namespace Sandbox\Test\TestCase\Controller;

use Sandbox\Model\Entity\BitmaskedRecord;
use Shim\TestSuite\IntegrationTestCase;

/**
 * @uses \Sandbox\Controller\ToolsExamplesController
 */
class ToolsExamplesControllerTest extends IntegrationTestCase {

	/**
	 * @var array<string>
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
	public function testBitmaskSearchFlag() {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'ToolsExamples', 'action' => 'bitmaskSearch', '?' => ['flags' => BitmaskedRecord::STATUS_FEATURED]]);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testBitmaskSearchFlagMulti() {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'ToolsExamples', 'action' => 'bitmaskSearch', '?' => ['flags' => [BitmaskedRecord::STATUS_FEATURED, BitmaskedRecord::STATUS_FLAGGED]]]);

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

	/**
	 * @return void
	 */
	public function testBitmaskEnums() {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'ToolsExamples', 'action' => 'bitmaskEnums']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
