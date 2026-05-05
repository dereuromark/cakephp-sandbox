<?php
declare(strict_types=1);

namespace Sandbox\Test\TestCase\Model\Table;

use App\Test\Factory\CountryFactory;
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
		$country = CountryFactory::make()->persist();

		$sandboxCity = $this->fetchTable('Sandbox.SandboxCities')->newEntity([
			'name' => 'My city',
			'country_id' => $country->id,
			'lat' => 52.5200,
			'lng' => 13.4050,
		]);
		$this->fetchTable('Sandbox.SandboxCities')->saveOrFail($sandboxCity);

		$this->assertTrue((bool)$sandboxCity);
	}

}
