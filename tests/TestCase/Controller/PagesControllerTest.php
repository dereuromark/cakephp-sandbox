<?php

namespace App\Test\TestCase\Controller;

use Cake\ORM\TableRegistry;
use Tools\TestSuite\IntegrationTestCase;

class PagesControllerTest extends IntegrationTestCase {

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
	public function testDisplay() {
		$this->get(['controller' => 'Pages', 'action' => 'display', 'best-practices']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
