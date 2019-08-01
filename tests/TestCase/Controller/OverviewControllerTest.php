<?php

namespace App\Test\TestCase\Controller;

use Cake\ORM\TableRegistry;
use Tools\TestSuite\IntegrationTestCase;

/**
 * OverviewControllerTest
 *
 * @uses \App\Controller\OverviewController
 */
class OverviewControllerTest extends IntegrationTestCase {

	/**
	 * @return void
	 */
	public function setUp() {
		parent::setUp();
	}

	/**
	 * @return void
	 */
	public function tearDown() {
		parent::tearDown();

		TableRegistry::clear();
	}

	/**
	 * Test index method
	 *
	 * @return void
	 */
	public function testIndex() {
		$this->get(['controller' => 'Overview', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
