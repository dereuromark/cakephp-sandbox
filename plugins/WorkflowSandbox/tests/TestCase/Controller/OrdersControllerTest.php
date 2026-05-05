<?php
declare(strict_types=1);

namespace WorkflowSandbox\Test\TestCase\Controller;

use Shim\TestSuite\IntegrationTestCase;
use WorkflowSandbox\Test\Factory\OrderFactory;

/**
 * @uses \WorkflowSandbox\Controller\OrdersController
 */
class OrdersControllerTest extends IntegrationTestCase {

	/**
	 * @return void
	 */
	public function testIndex(): void {
		$this->get(['plugin' => 'WorkflowSandbox', 'controller' => 'Orders', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testAdd(): void {
		$this->get(['plugin' => 'WorkflowSandbox', 'controller' => 'Orders', 'action' => 'add']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testView(): void {
		$order = OrderFactory::new()->save();

		$this->get(['plugin' => 'WorkflowSandbox', 'controller' => 'Orders', 'action' => 'view', $order->id]);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testDelete(): void {
		$order = OrderFactory::new()->save();

		$this->post(['plugin' => 'WorkflowSandbox', 'controller' => 'Orders', 'action' => 'delete', $order->id]);

		$this->assertResponseCode(302);
		$this->assertRedirect(['action' => 'index']);
	}

	/**
	 * @return void
	 */
	public function testReset(): void {
		OrderFactory::new()->save();

		$this->post(['plugin' => 'WorkflowSandbox', 'controller' => 'Orders', 'action' => 'reset']);

		$this->assertResponseCode(302);
		$this->assertRedirect(['action' => 'index']);
	}

}
