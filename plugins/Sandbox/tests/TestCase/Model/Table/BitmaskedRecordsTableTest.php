<?php
declare(strict_types = 1);

namespace Sandbox\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use Sandbox\Model\Table\BitmaskedRecordsTable;

/**
 * Sandbox\Model\Table\BitmaskedRecordsTable Test Case
 */
class BitmaskedRecordsTableTest extends TestCase {

	/**
	 * Test subject
	 *
	 * @var \Sandbox\Model\Table\BitmaskedRecordsTable
	 */
	protected $BitmaskedRecords;

	/**
	 * setUp method
	 *
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();
		$config = $this->getTableLocator()->exists('BitmaskedRecords') ? [] : ['className' => BitmaskedRecordsTable::class];
		$this->BitmaskedRecords = $this->getTableLocator()->get('BitmaskedRecords', $config);
	}

	/**
	 * tearDown method
	 *
	 * @return void
	 */
	public function tearDown(): void {
		unset($this->BitmaskedRecords);

		parent::tearDown();
	}

	/**
	 * @return void
	 */
	public function testValidationDefault(): void {
		$entity = $this->BitmaskedRecords->newEntity([]);
		$this->assertArrayHasKey('_required', $entity->getError('name'));

		$entity = $this->BitmaskedRecords->newEntity([
			'name' => str_repeat('x', 101),
			'flag_required' => '',
		]);
		$this->assertArrayHasKey('maxLength', $entity->getError('name'));
		$this->assertArrayHasKey('_empty', $entity->getError('flag_required'));

		$entity = $this->BitmaskedRecords->newEntity([
			'name' => 'My record',
			'flag_required' => 1,
		]);
		$this->assertEmpty($entity->getErrors());
	}

}
