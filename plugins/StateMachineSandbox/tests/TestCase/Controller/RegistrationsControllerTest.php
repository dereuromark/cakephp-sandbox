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
		'plugin.StateMachineSandbox.Registrations',
	];

	/**
	 * @return void
	 */
	public function testIndex(): void {
		$this->markTestIncomplete('Not implemented yet.');
	}

	/**
	 * @return void
	 */
	public function testView(): void {
		$this->markTestIncomplete('Not implemented yet.');
	}

	/**
	 * @return void
	 */
	public function testAdd(): void {
		$this->markTestIncomplete('Not implemented yet.');
	}

	/**
	 * @return void
	 */
	public function testEdit(): void {
		$this->markTestIncomplete('Not implemented yet.');
	}

	/**
	 * @return void
	 */
	public function testDelete(): void {
		$this->markTestIncomplete('Not implemented yet.');
	}

}
