<?php

namespace Sandbox\Test\TestCase\Controller;

use Cake\ORM\TableRegistry;
use Tools\TestSuite\IntegrationTestCase;

/**
 * App\Controller\SocialShareController Test Case
 *
 * @uses \Sandbox\Controller\SocialShareController
 */
class SocialShareControllerTest extends IntegrationTestCase {

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
	 * @return void
	 */
	public function testIndex() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'SocialShare', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
