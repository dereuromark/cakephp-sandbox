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
	 * @return void
	 */
	public function testSave(): void {
		$sandboxCity = $this->fetchTable('Sandbox.SandboxCities')->newEntity([
			'name' => 'My city',
			'country_id' => 1,
			'lat' => 52.5200,
			'lng' => 13.4050,
		]);
		$this->fetchTable('Sandbox.SandboxCities')->saveOrFail($sandboxCity);

		$this->assertTrue((bool)$sandboxCity);
	}

}
