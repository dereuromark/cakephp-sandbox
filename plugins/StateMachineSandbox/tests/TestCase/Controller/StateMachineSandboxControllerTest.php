<?php

namespace StateMachineSandbox\Test\TestCase\Controller;

use Cake\Routing\Router;
use Shim\TestSuite\IntegrationTestCase;

/**
 * App\Controller\AjaxExamplesController Test Case
 *
 * @uses \Sandbox\Controller\AjaxExamplesController
 * @uses \StateMachineSandbox\Controller\StateMachineSandboxController
 */
class StateMachineSandboxControllerTest extends IntegrationTestCase {

	/**
	 * @var bool
	 */
	protected $disableErrorHandlerMiddleware = true;

	/**
	 * @var array
	 */
	protected array $fixtures = [
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
		$this->get(['plugin' => 'StateMachineSandbox', 'controller' => 'StateMachineSandbox', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
