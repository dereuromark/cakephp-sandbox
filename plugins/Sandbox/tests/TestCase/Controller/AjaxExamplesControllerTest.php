<?php

namespace Sandbox\Test\TestCase\Controller;

use Cake\Routing\Router;
use Shim\TestSuite\IntegrationTestCase;

/**
 * App\Controller\AjaxExamplesController Test Case
 *
 * @uses \Sandbox\Controller\AjaxExamplesController
 */
class AjaxExamplesControllerTest extends IntegrationTestCase {

	/**
	 * @var array
	 */
	protected $fixtures = [
		//'plugin.Data.Countries',
		'app.Users',
	];

	/**
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();

		Router::extensions(['json']);
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
		$this->disableErrorHandlerMiddleware();

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
	public function testForm() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'AjaxExamples', 'action' => 'form']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testFormPostError() {
		$this->configRequest([
			'headers' => [
				'X_REQUESTED_WITH' => 'XMLHttpRequest',
			],
		]);

		$data = [
			'username' => '',
			'email' => '',
		];
		// For now without '_ext' => 'json'
		$this->post(['plugin' => 'Sandbox', 'controller' => 'AjaxExamples', 'action' => 'form'], $data);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
		//$flashMessage = '<div class="message error">Form not yet valid.</div>';
		$flashMessageJsonPiece = '"_message":[{"type":"error","message":"Form not yet valid."';
		$this->assertResponseContains($flashMessageJsonPiece);
	}

	/**
	 * @return void
	 */
	public function testFormPostSuccess() {
		$this->configRequest([
			'headers' => [
				'X_REQUESTED_WITH' => 'XMLHttpRequest',
			],
		]);

		$data = [
			'username' => 'foo',
			'email' => 'foo@bar.de',
		];
		$this->post(['plugin' => 'Sandbox', 'controller' => 'AjaxExamples', 'action' => 'form'], $data);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
		//$flashMessage = '<div class="message success">Simulated save.</div>';
		$flashMessageJsonPiece = '"_message":[{"type":"success","message":"Simulated save."';
		$this->assertResponseContains($flashMessageJsonPiece);
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
