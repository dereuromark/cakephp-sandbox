<?php

namespace Sandbox\Test\TestCase\Controller;

use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Tools\TestSuite\IntegrationTestCase;

/**
 * App\Controller\AjaxExamplesController Test Case
 */
class AjaxExamplesControllerTest extends IntegrationTestCase {

	/**
	 * @var array
	 */
	public $fixtures = ['plugin.Data.Countries'];

	/**
	 * @return void
	 */
	public function setUp() {
		parent::setUp();

		Router::extensions(['json']);
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
	public function testSimple() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'AjaxExamples', 'action' => 'simple']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testSimpleAjax() {
		$this->configRequest([
			'headers' => [
				'X_REQUESTED_WITH' => 'XMLHttpRequest',
			],
		]);

		$this->get(['plugin' => 'Sandbox', 'controller' => 'AjaxExamples', 'action' => 'simple', '_ext' => 'json']);

		$this->assertResponseCode(200);
		$this->assertResponseContains('"now":');
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

	/**
	 * @return void
	 */
	public function testPagination() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'AjaxExamples', 'action' => 'pagination']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testEndlessScroll() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'AjaxExamples', 'action' => 'endlessScroll']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
