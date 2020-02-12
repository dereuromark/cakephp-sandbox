<?php

namespace App\Test\TestCase\Controller;

use Cake\ORM\TableRegistry;
use Shim\TestSuite\IntegrationTestCase;

/**
 * @uses \App\Controller\PagesController
 */
class PagesControllerTest extends IntegrationTestCase {

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

		TableRegistry::clear();
	}

	/**
	 * Test index method
	 *
	 * @return void
	 */
	public function testDisplay() {
		$this->get(['controller' => 'Pages', 'action' => 'display', 'best-practices']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
