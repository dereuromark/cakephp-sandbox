<?php

namespace App\Test\TestCase\Controller;

use Cake\ORM\TableRegistry;
use Tools\TestSuite\IntegrationTestCase;

/**
 * @uses \App\Controller\MiscController
 */
class MiscControllerTest extends IntegrationTestCase {

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
		$this->get(['controller' => 'Misc', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * Test index method
	 *
	 * @return void
	 */
	public function testConvertText() {
		$this->get(['controller' => 'Misc', 'action' => 'convertText']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
