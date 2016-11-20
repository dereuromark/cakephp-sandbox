<?php

namespace Sandbox\Test\TestCase\Controller;

use Cake\ORM\TableRegistry;
use Tools\TestSuite\IntegrationTestCase;

/**
 * App\Controller\AjaxExamplesController Test Case
 */
class AjaxExamplesControllerTest extends IntegrationTestCase {

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
		$this->get(['plugin' => 'Sandbox', 'controller' => 'AjaxExamples', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testToggle() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'AjaxExamples', 'action' => 'toggle']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testTogglePost() {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'AjaxExamples', 'action' => 'toggle'], []);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
