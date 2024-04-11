<?php
declare(strict_types=1);

namespace Sandbox\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * @uses \Sandbox\Controller\QrCodeExamplesController
 */
class QrCodeExamplesControllerTest extends TestCase {

	use IntegrationTestTrait;

	/**
	 * @uses \Sandbox\Controller\QrCodeExamplesController::index()
	 * @return void
	 */
	public function testIndex(): void {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'QrCodeExamples', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @uses \Sandbox\Controller\QrCodeExamplesController::index()
	 * @return void
	 */
	public function testIndexPost(): void {
		$this->disableErrorHandlerMiddleware();

		$data = [
			'content' => 'Foo Bar',
		];
		$this->post(['plugin' => 'Sandbox', 'controller' => 'QrCodeExamples', 'action' => 'index'], $data);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 *@uses \Sandbox\Controller\QrCodeExamplesController::svg()
	 * @return void
	 */
	public function testSvg(): void {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'QrCodeExamples', 'action' => 'svg']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 *@uses \Sandbox\Controller\QrCodeExamplesController::svg()
	 * @return void
	 */
	public function testSvgPost(): void {
		$this->disableErrorHandlerMiddleware();

		$data = [
			'type' => 'sms',
			'Sms' => [
				'number' => '1234567890',
				'content' => 'Foo Bar',
			],
		];
		$this->post(['plugin' => 'Sandbox', 'controller' => 'QrCodeExamples', 'action' => 'svg'], $data);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 *@uses \Sandbox\Controller\QrCodeExamplesController::png()
	 * @return void
	 */
	public function testPng(): void {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'QrCodeExamples', 'action' => 'png']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 *@uses \Sandbox\Controller\QrCodeExamplesController::png()
	 * @return void
	 */
	public function testPngPost(): void {
		$this->disableErrorHandlerMiddleware();

		$data = [
			'type' => 'sms',
			'Sms' => [
				'number' => '1234567890',
				'content' => 'Foo Bar',
			],
		];
		$this->post(['plugin' => 'Sandbox', 'controller' => 'QrCodeExamples', 'action' => 'png'], $data);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
