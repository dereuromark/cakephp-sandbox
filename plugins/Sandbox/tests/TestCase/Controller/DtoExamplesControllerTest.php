<?php

namespace Sandbox\Test\TestCase\Controller;

use Cake\ORM\TableRegistry;
use Tools\TestSuite\IntegrationTestCase;

/**
 * App\Controller\DtoExamplesController Test Case
 *
 * @uses \Sandbox\Controller\DtoExamplesController
 */
class DtoExamplesControllerTest extends IntegrationTestCase {

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
		$this->get(['plugin' => 'Sandbox', 'controller' => 'DtoExamples', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testGithub() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'DtoExamples', 'action' => 'github']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
