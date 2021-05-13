<?php
declare(strict_types = 1);

namespace Sandbox\Test\TestCase\Service\Localized;

use Cake\TestSuite\TestCase;
use Sandbox\Service\Localized\ValidationService;

class ValidationServiceTest extends TestCase {

	/**
	 * @var \Sandbox\Service\Localized\ValidationService
	 */
	protected $service;

	/**
	 * Fixtures
	 *
	 * @var array
	 */
	protected $fixtures = [
		'plugin.Sandbox.BitmaskedRecords',
	];

	/**
	 * setUp method
	 *
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();

		$this->service = new ValidationService();
	}

	/**
	 * tearDown method
	 *
	 * @return void
	 */
	public function tearDown(): void {
		unset($this->service);

		parent::tearDown();
	}

	/**
	 * Test validationDefault method
	 *
	 * @return void
	 */
	public function testGetAvailable(): void {
		$result = $this->service->getAvailable();

		$this->assertNotEmpty($result);
		$this->assertNotEmpty($result['De']);
	}

}
