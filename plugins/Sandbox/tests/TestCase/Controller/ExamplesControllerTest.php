<?php

namespace Sandbox\Test\TestCase\Controller;

use Cake\ORM\TableRegistry;
use Tools\TestSuite\IntegrationTestCase;

/**
 * @uses \Sandbox\Controller\ExamplesController
 */
class ExamplesControllerTest extends IntegrationTestCase {

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
	public function testMarkup() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Examples', 'action' => 'markup']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
