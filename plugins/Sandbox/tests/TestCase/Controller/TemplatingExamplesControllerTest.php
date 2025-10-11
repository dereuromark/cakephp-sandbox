<?php
declare(strict_types=1);

namespace Sandbox\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * @uses \Sandbox\Controller\TemplatingExamplesController
 */
class TemplatingExamplesControllerTest extends TestCase {

	use IntegrationTestTrait;

	/**
	 * @uses \Sandbox\Controller\TemplatingExamplesController::index()
	 * @return void
	 */
	public function testIndex(): void {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'TemplatingExamples', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @uses \Sandbox\Controller\TemplatingExamplesController::html()
	 * @return void
	 */
	public function testHtml(): void {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'TemplatingExamples', 'action' => 'html']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @uses \Sandbox\Controller\TemplatingExamplesController::icons()
	 * @return void
	 */
	public function testIcons(): void {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'TemplatingExamples', 'action' => 'icons']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @uses \Sandbox\Controller\TemplatingExamplesController::iconSnippetHelper()
	 * @return void
	 */
	public function testIconSnippetHelper(): void {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'TemplatingExamples', 'action' => 'iconSnippetHelper']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @uses \Sandbox\Controller\TemplatingExamplesController::iconSets()
	 * @return void
	 */
	public function testIconSets(): void {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'TemplatingExamples', 'action' => 'iconSets', 'fa6']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @uses \Sandbox\Controller\TemplatingExamplesController::iconSets()
	 * @return void
	 */
	public function testIconSetsBs(): void {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'TemplatingExamples', 'action' => 'iconSets', 'bs']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @uses \Sandbox\Controller\TemplatingExamplesController::svgIcons()
	 * @return void
	 */
	public function testSvgIcons(): void {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'TemplatingExamples', 'action' => 'svgIcons']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
