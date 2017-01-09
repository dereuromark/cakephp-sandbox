<?php

namespace Sandbox\Test\TestCase\Controller;

use Cake\ORM\TableRegistry;
use Tools\TestSuite\IntegrationTestCase;

/**
 */
class CalendarControllerTest extends IntegrationTestCase {

	/**
	 * @var array
	 */
	public $fixtures = ['plugin.Sandbox.Events', 'plugin.Data.CountryProvinces'];

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
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Calendar', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testView() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Calendar', 'action' => 'view', 1]);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
