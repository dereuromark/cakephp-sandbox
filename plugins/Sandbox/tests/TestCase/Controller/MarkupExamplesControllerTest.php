<?php
declare(strict_types = 1);

namespace Sandbox\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * Sandbox\Controller\MarkupExamplesController Test Case
 *
 * @uses \Sandbox\Controller\MarkupExamplesController
 */
class MarkupExamplesControllerTest extends TestCase {

	use IntegrationTestTrait;

	/**
	 * @return void
	 */
	public function testIndex(): void {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'MarkupExamples', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testMarkup(): void {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'MarkupExamples', 'action' => 'markup']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function _testMarkdown(): void {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'MarkupExamples', 'action' => 'markdown']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
