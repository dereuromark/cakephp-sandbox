<?php
declare(strict_types=1);

namespace Sandbox\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use Sandbox\Model\Table\SandboxCitiesTable;

class SandboxCitiesTableTest extends TestCase {

	/**
	 * Test subject
	 *
	 * @var \Sandbox\Model\Table\SandboxCitiesTable
	 */
	protected $SandboxCities;

	/**
	 * @var list<string>
	 */
	protected array $fixtures = [
		'plugin.Sandbox.SandboxCities',
		'plugin.Data.Countries',
	];

	/**
	 * @return void
	 */
	protected function setUp(): void {
		parent::setUp();
		$config = $this->getTableLocator()->exists('SandboxCities') ? [] : ['className' => SandboxCitiesTable::class];
		$this->SandboxCities = $this->getTableLocator()->get('SandboxCities', $config);
	}

	/**
	 * @return void
	 */
	protected function tearDown(): void {
		unset($this->SandboxCities);

		parent::tearDown();
	}

	/**
	 * @uses \Sandbox\Model\Table\SandboxCitiesTable::validationDefault()
	 * @return void
	 */
	public function testValidationDefault(): void {
		$this->markTestIncomplete('Not implemented yet.');
	}

	/**
	 * @uses \Sandbox\Model\Table\SandboxCitiesTable::buildRules()
	 * @return void
	 */
	public function testBuildRules(): void {
		$this->markTestIncomplete('Not implemented yet.');
	}

}
