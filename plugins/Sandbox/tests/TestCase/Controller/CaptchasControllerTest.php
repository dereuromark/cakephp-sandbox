<?php

namespace Sandbox\Test\TestCase\Controller;

use Tools\TestSuite\IntegrationTestCase;

/**
 * @uses \Sandbox\Controller\CaptchasController
 */
class CaptchasControllerTest extends IntegrationTestCase {

	/**
	 * @var array
	 */
	protected $fixtures = [
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

}
