<?php

namespace Sandbox\Test\TestCase\Controller;

use Sandbox\Controller\MenuController;
use Cake\ORM\TableRegistry;
use Tools\TestSuite\IntegrationTestCase;

/**
 * App\Controller\BootstrapController Test Case
 */
class MenuControllerTest extends IntegrationTestCase {

	public $fixtures = ['plugin.Sandbox.SandboxCategories'];

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
		$this->get(array('plugin' => 'Sandbox', 'controller' => 'Menu', 'action' => 'index'));

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
