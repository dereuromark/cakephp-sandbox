<?php

namespace App\Test\TestCase\Controller;

use Cake\ORM\TableRegistry;
use Tools\TestSuite\IntegrationTestCase;

/**
 */
class PagesControllerTest extends IntegrationTestCase {

	public function setUp() {
		parent::setUp();
	}

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
