<?php
declare(strict_types=1);

namespace StateMachineSandbox\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use StateMachineSandbox\Model\Table\RegistrationsTable;

class RegistrationsTableTest extends TestCase {

	/**
	 * Test subject
	 *
	 * @var \StateMachineSandbox\Model\Table\RegistrationsTable
	 */
	protected $Registrations;

	/**
	 * @var array<string>
	 */
	protected array $fixtures = [
		'plugin.StateMachineSandbox.Registrations',
		'app.Users',
	];

	/**
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();
		$config = $this->getTableLocator()->exists('Registrations') ? [] : ['className' => RegistrationsTable::class];
		$this->Registrations = $this->getTableLocator()->get('Registrations', $config);
	}

	/**
	 * @return void
	 */
	public function tearDown(): void {
		unset($this->Registrations);

		parent::tearDown();
	}

	/**
	 * @return void
	 */
	public function testValidationDefault(): void {
		$this->markTestIncomplete('Not implemented yet.');
	}

	/**
	 * @return void
	 */
	public function testBuildRules(): void {
		$this->markTestIncomplete('Not implemented yet.');
	}

}
