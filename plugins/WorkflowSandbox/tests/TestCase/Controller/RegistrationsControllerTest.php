<?php
declare(strict_types=1);

namespace WorkflowSandbox\Test\TestCase\Controller;

use Shim\TestSuite\IntegrationTestCase;
use WorkflowSandbox\Test\Factory\RegistrationFactory;

/**
 * @uses \WorkflowSandbox\Controller\RegistrationsController
 */
class RegistrationsControllerTest extends IntegrationTestCase {

	/**
	 * @return void
	 */
	public function testIndex(): void {
		$this->get(['plugin' => 'WorkflowSandbox', 'controller' => 'Registrations', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testAdd(): void {
		$this->get(['plugin' => 'WorkflowSandbox', 'controller' => 'Registrations', 'action' => 'add']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testView(): void {
		$registration = RegistrationFactory::new()->save();

		$this->get(['plugin' => 'WorkflowSandbox', 'controller' => 'Registrations', 'action' => 'view', $registration->id]);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testDelete(): void {
		$registration = RegistrationFactory::new()->save();

		$this->post(['plugin' => 'WorkflowSandbox', 'controller' => 'Registrations', 'action' => 'delete', $registration->id]);

		$this->assertResponseCode(302);
		$this->assertRedirect(['action' => 'index']);
	}

	/**
	 * @return void
	 */
	public function testReset(): void {
		RegistrationFactory::new()->save();

		$this->post(['plugin' => 'WorkflowSandbox', 'controller' => 'Registrations', 'action' => 'reset']);

		$this->assertResponseCode(302);
		$this->assertRedirect(['action' => 'index']);
	}

}
