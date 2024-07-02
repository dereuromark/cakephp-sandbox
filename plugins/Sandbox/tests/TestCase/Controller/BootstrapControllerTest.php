<?php

namespace Sandbox\Test\TestCase\Controller;

use Shim\TestSuite\IntegrationTestCase;

/**
 * @uses \Sandbox\Controller\BootstrapController
 */
class BootstrapControllerTest extends IntegrationTestCase {

	/**
	 * @var array<string>
	 */
	protected array $fixtures = [
		'plugin.Sandbox.SandboxAnimals',
		'plugin.Sandbox.SandboxUsers',
	];

	/**
	 * @return void
	 */
	public function testIndex() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Bootstrap', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
