<?php

namespace Sandbox\Test\TestCase\Controller;

use Sandbox\Controller\BootstrapController;
use Cake\ORM\TableRegistry;
use Tools\TestSuite\IntegrationTestCase;

/**
 * App\Controller\BootstrapController Test Case
 */
class BootstrapControllerTest extends IntegrationTestCase {

	public $fixtures = ['plugin.Sandbox.SandboxAnimals', 'plugin.Sandbox.SandboxUsers'];

	public function setUp() {
		parent::setUp();
	}

	public function tearDown() {
		parent::tearDown();

		TableRegistry::clear();
	}

	/**
	 * Test index method
	 *
	 * @return void
	 */
	public function testIndex() {
		$this->get(array('plugin' => 'Sandbox', 'controller' => 'Bootstrap', 'action' => 'index'));

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
