<?php
declare(strict_types = 1);

namespace Sandbox\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Sandbox\Model\Table\ExposedUsersTable;

/**
 * Sandbox\Model\Table\ExposedUsersTable Test Case
 */
class ExposedUsersTableTest extends TestCase {

	/**
	 * Test subject
	 *
	 * @var \Sandbox\Model\Table\ExposedUsersTable
	 */
	protected $ExposedUsers;

	/**
	 * Fixtures
	 *
	 * @var array
	 */
	protected array $fixtures = [
		'plugin.Sandbox.ExposedUsers',
	];

	/**
	 * setUp method
	 *
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();
		$config = TableRegistry::getTableLocator()->exists('ExposedUsers') ? [] : ['className' => ExposedUsersTable::class];
		$this->ExposedUsers = TableRegistry::getTableLocator()->get('ExposedUsers', $config);
	}

	/**
	 * tearDown method
	 *
	 * @return void
	 */
	public function tearDown(): void {
		unset($this->ExposedUsers);

		parent::tearDown();
	}

	/**
	 * Test initialize method
	 *
	 * @return void
	 */
	public function testInitialize(): void {
		$this->markTestIncomplete('Not implemented yet.');
	}

	/**
	 * Test validationDefault method
	 *
	 * @return void
	 */
	public function testValidationDefault(): void {
		$this->markTestIncomplete('Not implemented yet.');
	}

	/**
	 * Test buildRules method
	 *
	 * @return void
	 */
	public function testBuildRules(): void {
		$this->markTestIncomplete('Not implemented yet.');
	}

}
