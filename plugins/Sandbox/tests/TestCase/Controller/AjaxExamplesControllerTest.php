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
	 * @var bool
	 */
	protected bool $disableErrorHandlerMiddleware = true;

	/**
	 * @var array<string>
	 */
	protected array $fixtures = [
		'plugin.Data.Countries',
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
		$errorPart = 'required is-invalid';
		$this->assertResponseContains($errorPart);

		$result = $this->_response->getHeader('X-Flash');
		$expected = [
			'[{"message":"Form not yet valid.","type":"error","params":[]}]',
		];
		$this->assertSame($expected, $result);
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

		$result = $this->_response->getHeader('X-Flash');
		$expected = [
			'[{"message":"Simulated save.","type":"success","params":[]}]',
		];
		$this->assertSame($expected, $result);
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
		$this->disableErrorHandlerMiddleware();

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

	/**
	 * @return void
	 */
	public function testChainedDropdowns() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'AjaxExamples', 'action' => 'chainedDropdowns']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testEditInPlace() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'AjaxExamples', 'action' => 'editInPlace']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testRedirecting() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'AjaxExamples', 'action' => 'redirecting']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testRedirectingPrevented() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'AjaxExamples', 'action' => 'redirectingPrevented']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testTable() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'AjaxExamples', 'action' => 'table']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
