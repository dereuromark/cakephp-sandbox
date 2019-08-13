<?php

namespace Sandbox\Test\TestCase\Controller;

use Cake\ORM\TableRegistry;
use Tools\TestSuite\IntegrationTestCase;

/**
 * @uses \Sandbox\Controller\ToolsExamplesController
 */
class ToolsExamplesControllerTest extends IntegrationTestCase {

	/**
	 * @var array
	 */
	public $fixtures = [
		'app.Users',
		'plugin.Sandbox.SandboxUsers',
		'plugin.Sandbox.SandboxAnimals'
	];

	/**
	 * @return void
	 */
	public function setUp() {
		parent::setUp();
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
		$this->get(['plugin' => 'Sandbox', 'controller' => 'ToolsExamples', 'action' => 'meter']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
