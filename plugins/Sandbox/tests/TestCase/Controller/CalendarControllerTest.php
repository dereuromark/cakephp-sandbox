<?php

namespace Sandbox\Test\TestCase\Controller;

use Cake\ORM\TableRegistry;
use Tools\TestSuite\IntegrationTestCase;

/**
 * @uses \Sandbox\Controller\CalendarController
 */
class CalendarControllerTest extends IntegrationTestCase {

	/**
	 * @var array
	 */
	protected $fixtures = [
		'plugin.Sandbox.Events',
		'plugin.Data.States',
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
