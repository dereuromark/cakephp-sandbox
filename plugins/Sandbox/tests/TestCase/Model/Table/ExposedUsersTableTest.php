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
	 * setUp method
	 *
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();
		$config = TableRegistry::getTableLocator()->exists('ExposedUsers') ? [] : ['className' => ExposedUsersTable::class];
		$this->ExposedUsers = $this->fetchTable('ExposedUsers', $config);
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
	 * @return void
	 */
	public function testInitialize(): void {
		$this->assertSame('exposed_users', $this->ExposedUsers->getTable());
		$this->assertSame('name', $this->ExposedUsers->getDisplayField());
		$this->assertTrue($this->ExposedUsers->hasBehavior('Timestamp'));
		$this->assertTrue($this->ExposedUsers->hasBehavior('Expose'));
	}

	/**
	 * @return void
	 */
	public function testValidationDefault(): void {
		$entity = $this->ExposedUsers->newEntity(['some_field' => 'not alphanumeric!']);
		$this->assertArrayHasKey('valid', $entity->getError('some_field'));

		$entity = $this->ExposedUsers->newEntity(['some_field' => 'abc123']);
		$this->assertEmpty($entity->getError('some_field'));
	}

}
