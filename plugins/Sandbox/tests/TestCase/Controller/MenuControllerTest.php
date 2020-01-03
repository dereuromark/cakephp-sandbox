<?php

namespace Sandbox\Test\TestCase\Controller;

use Cake\ORM\TableRegistry;
use Tools\TestSuite\IntegrationTestCase;

/**
 * App\Controller\BootstrapController Test Case
 *
 * @uses \Sandbox\Controller\MenuController
 */
class MenuControllerTest extends IntegrationTestCase {

	/**
	 * @var array
	 */
	protected $fixtures = [
		'plugin.Sandbox.SandboxCategories',
	];

	/**
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();
	}

	/**
	 * @return void
	 */
	public function tearDown(): void {
		parent::tearDown();

		TableRegistry::clear();
	}

	/**
	 * @return void
	 */
	public function testIndex() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Menu', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
