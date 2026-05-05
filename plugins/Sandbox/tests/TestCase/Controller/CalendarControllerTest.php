<?php

namespace Sandbox\Test\TestCase\Controller;

use App\Test\Factory\StateFactory;
use Sandbox\Test\Factory\EventFactory;
use Shim\TestSuite\IntegrationTestCase;

/**
 * @uses \Sandbox\Controller\CalendarController
 */
class CalendarControllerTest extends IntegrationTestCase {

	/**
	 * @return void
	 */
	public function testIndex() {
		$this->disableErrorHandlerMiddleware();

		StateFactory::make()->persist();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'Calendar', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testView() {
		$this->disableErrorHandlerMiddleware();

		$event = EventFactory::make()->persist();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'Calendar', 'action' => 'view', $event->id]);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
