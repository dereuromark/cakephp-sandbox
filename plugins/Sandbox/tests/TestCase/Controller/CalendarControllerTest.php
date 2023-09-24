<?php

namespace Sandbox\Test\TestCase\Controller;

use Shim\TestSuite\IntegrationTestCase;

/**
 * @uses \Sandbox\Controller\CalendarController
 */
class CalendarControllerTest extends IntegrationTestCase {

	/**
	 * @var array
	 */
	protected array $fixtures = [
		'plugin.Sandbox.Events',
		'plugin.Data.States',
	];

	/**
	 * @return void
	 */
	public function testIndex() {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'Calendar', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testView() {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'Calendar', 'action' => 'view', 1]);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
