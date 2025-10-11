<?php

namespace App\Test\TestCase\Controller;

use Shim\TestSuite\IntegrationTestCase;

/**
 * ExportControllerTest
 *
 * @uses \App\Controller\ExportController
 */
class ExportControllerTest extends IntegrationTestCase {

	/**
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();
	}

	/**
	 * @return void
	 */
	public function tearDown(): void {
		parent::tearDown();

		//TableRegistry::clear();
	}

	/**
	 * Test index method
	 *
	 * @return void
	 */
	public function testIndex() {
		$this->get(['controller' => 'Export', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testContinents() {
		$this->markTestSkipped('Requires Data plugin tables to be migrated');
	}

	/**
	 * @return void
	 */
	public function testCountries() {
		$this->markTestSkipped('Requires Data plugin tables to be migrated');
	}

	/**
	 * @return void
	 */
	public function testCurrencies() {
		$this->markTestSkipped('Requires Data plugin tables to be migrated');
	}

	/**
	 * @return void
	 */
	public function testLanguages() {
		$this->markTestSkipped('Requires Data plugin tables to be migrated');
	}

	/**
	 * @return void
	 */
	public function testMimeTypes() {
		$this->markTestSkipped('Requires Data plugin tables to be migrated');
	}

	/**
	 * @return void
	 */
	public function testPostalCodes() {
		$this->markTestSkipped('Requires Data plugin tables to be migrated');
	}

	/**
	 * @return void
	 */
	public function testStates() {
		$this->markTestSkipped('Requires Data plugin tables to be migrated');
	}

	/**
	 * @return void
	 */
	public function testTimezones() {
		$this->markTestSkipped('Requires Data plugin tables to be migrated');
	}

}
