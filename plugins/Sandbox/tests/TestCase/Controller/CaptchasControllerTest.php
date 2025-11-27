<?php

namespace Sandbox\Test\TestCase\Controller;

use Shim\TestSuite\IntegrationTestCase;

/**
 * @uses \Sandbox\Controller\CaptchasController
 */
class CaptchasControllerTest extends IntegrationTestCase {

	/**
	 * @var array<string>
	 */
	protected array $fixtures = [
		'plugin.Captcha.Captchas',
		'plugin.Sandbox.SandboxAnimals',
	];

	/**
	 * @return void
	 */
	public function testIndex() {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'Captchas', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testMath() {
		$this->disableErrorHandlerMiddleware();

		$this->configRequest([
			'environment' => [
				'REMOTE_ADDR' => '1',
			],
		]);

		$this->get(['plugin' => 'Sandbox', 'controller' => 'Captchas', 'action' => 'math']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testMathPostInvalid() {
		$this->disableErrorHandlerMiddleware();

		$this->configRequest([
			'environment' => [
				'REMOTE_ADDR' => '1',
			],
		]);

		$data = [
			'captcha_result' => '',
			'name' => 'Mouse',
		];
		$this->post(['plugin' => 'Sandbox', 'controller' => 'Captchas', 'action' => 'math'], $data);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testModelLess() {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'Captchas', 'action' => 'modelLess']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * Test that the captcha image is publicly accessible (no auth required).
	 *
	 * @return void
	 */
	public function testCaptchaImageIsPublic(): void {
		$this->get(['plugin' => 'Captcha', 'controller' => 'Captcha', 'action' => 'display']);

		$this->assertResponseCode(200);
		$this->assertContentType('image/png');
	}

}
