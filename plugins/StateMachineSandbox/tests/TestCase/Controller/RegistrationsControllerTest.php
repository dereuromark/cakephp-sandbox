<?php
declare(strict_types=1);

namespace StateMachineSandbox\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * @uses \StateMachineSandbox\Controller\RegistrationsController
 */
class RegistrationsControllerTest extends TestCase {

	use IntegrationTestTrait;

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
	public function testIndex(): void {
		$this->get(['plugin' => 'StateMachineSandbox', 'controller' => 'Registrations', 'action' => 'index']);

		$this->assertResponseCode(200);
	}

	/**
	 * @return void
	 */
	public function testView(): void {
		$this->markTestIncomplete('Requires proper fixture with matching session_id and state machine data');
	}

	/**
	 * @return void
	 */
	public function testDelete(): void {
		$this->markTestIncomplete('Requires proper fixture with matching session_id and state machine data');
	}

}
