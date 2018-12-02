<?php

namespace Sandbox\Test\TestCase\Controller;

use Cake\ORM\TableRegistry;
use Tools\TestSuite\IntegrationTestCase;

class ExamplesControllerTest extends IntegrationTestCase {

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
	public function testMarkup() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Examples', 'action' => 'markup']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
