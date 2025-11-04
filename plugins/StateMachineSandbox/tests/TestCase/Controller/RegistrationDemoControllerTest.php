<?php

namespace StateMachineSandbox\Test\TestCase\Controller;

use Shim\TestSuite\IntegrationTestCase;

/**
 * StateMachineSandbox\Controller\RegistrationDemoController Test Case
 *
 * @uses \StateMachineSandbox\Controller\RegistrationDemoController
 */
class RegistrationDemoControllerTest extends IntegrationTestCase {

	/**
	 * @var bool
	 */
	protected bool $disableErrorHandlerMiddleware = true;

	/**
	 * @var array<string>
	 */
	protected array $fixtures = [
		'app.Users',
		'plugin.StateMachineSandbox.Registrations',
	];

	/**
	 * @return void
	 */
	public function testIndex() {
		$this->get(['plugin' => 'StateMachineSandbox', 'controller' => 'RegistrationDemo', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testRegister() {
		$this->get(['plugin' => 'StateMachineSandbox', 'controller' => 'RegistrationDemo', 'action' => 'register']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testModeratorPanel() {
		$this->get(['plugin' => 'StateMachineSandbox', 'controller' => 'RegistrationDemo', 'action' => 'moderatorPanel']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testAdminPanel() {
		$this->get(['plugin' => 'StateMachineSandbox', 'controller' => 'RegistrationDemo', 'action' => 'adminPanel']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testProcess() {
		$this->get(['plugin' => 'StateMachineSandbox', 'controller' => 'RegistrationDemo', 'action' => 'process']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testRemoveJob() {
		$this->expectException('Cake\Datasource\Exception\RecordNotFoundException');
		$this->post(['plugin' => 'StateMachineSandbox', 'controller' => 'RegistrationDemo', 'action' => 'removeJob', 1]);
	}

}
