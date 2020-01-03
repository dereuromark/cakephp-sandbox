<?php

namespace Sandbox\Test\TestCase\Controller;

use Cake\ORM\TableRegistry;
use Tools\TestSuite\IntegrationTestCase;

/**
 * @uses \Sandbox\Controller\HashidsController
 */
class HashidsControllerTest extends IntegrationTestCase {

	/**
	 * @var array
	 */
	protected $fixtures = [
		'plugin.Data.Countries',
	];

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
	 * @return void
	 */
	public function testIndex() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Hashids', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
