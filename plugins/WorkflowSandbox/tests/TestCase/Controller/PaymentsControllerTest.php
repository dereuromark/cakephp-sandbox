<?php
declare(strict_types=1);

namespace WorkflowSandbox\Test\TestCase\Controller;

use Shim\TestSuite\IntegrationTestCase;
use WorkflowSandbox\Test\Factory\PaymentFactory;

/**
 * @uses \WorkflowSandbox\Controller\PaymentsController
 */
class PaymentsControllerTest extends IntegrationTestCase {

	/**
	 * @return void
	 */
	public function testIndex(): void {
		$this->get(['plugin' => 'WorkflowSandbox', 'controller' => 'Payments', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testAdd(): void {
		$this->get(['plugin' => 'WorkflowSandbox', 'controller' => 'Payments', 'action' => 'add']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testView(): void {
		$payment = PaymentFactory::new()->save();

		$this->get(['plugin' => 'WorkflowSandbox', 'controller' => 'Payments', 'action' => 'view', $payment->id]);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testDelete(): void {
		$payment = PaymentFactory::new()->save();

		$this->post(['plugin' => 'WorkflowSandbox', 'controller' => 'Payments', 'action' => 'delete', $payment->id]);

		$this->assertResponseCode(302);
		$this->assertRedirect(['action' => 'index']);
	}

	/**
	 * @return void
	 */
	public function testSimulate(): void {
		$payment = PaymentFactory::new()->save();

		$this->post(['plugin' => 'WorkflowSandbox', 'controller' => 'Payments', 'action' => 'simulate', $payment->id]);

		$this->assertResponseCode(302);
	}

}
