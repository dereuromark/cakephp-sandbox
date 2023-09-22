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
	 * Fixtures
	 *
	 * @var array
	 */
	protected array $fixtures = [
		'plugin.Sandbox.BitmaskedRecords',
	];

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
	 * Test validationDefault method
	 *
	 * @return void
	 */
	public function testValidationDefault(): void {
		$this->markTestIncomplete('Not implemented yet.');
	}

}
