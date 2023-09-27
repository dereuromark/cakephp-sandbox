<?php

namespace App\Test\TestCase\Controller;

use Cake\ORM\TableRegistry;
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

}
