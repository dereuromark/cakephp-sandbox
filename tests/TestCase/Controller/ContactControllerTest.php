<?php

namespace App\Test\TestCase\Controller;

use Cake\ORM\TableRegistry;
use Tools\TestSuite\IntegrationTestCase;

/**
 */
class ContactControllerTest extends IntegrationTestCase {

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
		$this->get(['controller' => 'Contact', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * Test index method
	 *
	 * @return void
	 */
	public function testIndexPost() {
		$data = [
			'name' => '',
			'email' => '',
			'message' => '',
			'subject' => '',
		];
		$this->post(['controller' => 'Contact', 'action' => 'index'], $data);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * Test index method
	 *
	 * @return void
	 */
	public function testIndexPostValid() {
		$data = [
			'name' => 'Foo',
			'email' => 'foo@bar.de',
			'message' => 'Test',
			'subject' => 'Test',
		];
		$this->post(['controller' => 'Contact', 'action' => 'index'], $data);

		$this->assertResponseCode(302);
		$this->assertRedirect();
	}

}
