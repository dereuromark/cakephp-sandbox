<?php
declare(strict_types=1);

namespace Sandbox\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Sandbox\Test\Factory\SandboxProfileFactory;

/**
 * @uses \Sandbox\Controller\DecimalExamplesController
 */
class DecimalExamplesControllerTest extends TestCase {

	use IntegrationTestTrait;

	/**
	 * @uses \Sandbox\Controller\DecimalExamplesController::index()
	 * @return void
	 */
	public function testIndex(): void {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'DecimalExamples', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @uses \Sandbox\Controller\DecimalExamplesController::forms()
	 * @return void
	 */
	public function testForms(): void {
		$this->disableErrorHandlerMiddleware();

		SandboxProfileFactory::new()->save();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'DecimalExamples', 'action' => 'forms']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @uses \Sandbox\Controller\DecimalExamplesController::validation()
	 * @return void
	 */
	public function testValidation(): void {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'DecimalExamples', 'action' => 'validation']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @uses \Sandbox\Controller\DecimalExamplesController::api()
	 * @return void
	 */
	public function testApi(): void {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'DecimalExamples', 'action' => 'api']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @uses \Sandbox\Controller\DecimalExamplesController::numberHelper()
	 * @return void
	 */
	public function testNumberHelper(): void {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'DecimalExamples', 'action' => 'numberHelper']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
