<?php
declare(strict_types=1);

namespace WorkflowSandbox\Test\TestCase\Controller;

use Shim\TestSuite\IntegrationTestCase;
use WorkflowSandbox\Test\Factory\TicketFactory;

/**
 * @uses \WorkflowSandbox\Controller\TicketsController
 */
class TicketsControllerTest extends IntegrationTestCase {

	/**
	 * @return void
	 */
	public function testIndex(): void {
		$this->get(['plugin' => 'WorkflowSandbox', 'controller' => 'Tickets', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testAdd(): void {
		$this->get(['plugin' => 'WorkflowSandbox', 'controller' => 'Tickets', 'action' => 'add']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testView(): void {
		$ticket = TicketFactory::make()->persist();

		$this->get(['plugin' => 'WorkflowSandbox', 'controller' => 'Tickets', 'action' => 'view', $ticket->id]);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testDelete(): void {
		$ticket = TicketFactory::make()->persist();

		$this->post(['plugin' => 'WorkflowSandbox', 'controller' => 'Tickets', 'action' => 'delete', $ticket->id]);

		$this->assertResponseCode(302);
		$this->assertRedirect(['action' => 'index']);
	}

	/**
	 * @return void
	 */
	public function testReset(): void {
		TicketFactory::make()->persist();

		$this->post(['plugin' => 'WorkflowSandbox', 'controller' => 'Tickets', 'action' => 'reset']);

		$this->assertResponseCode(302);
		$this->assertRedirect(['action' => 'index']);
	}

}
