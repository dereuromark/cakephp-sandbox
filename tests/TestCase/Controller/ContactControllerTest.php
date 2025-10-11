<?php

namespace App\Test\TestCase\Controller;

use Cake\Core\Configure;
use Shim\TestSuite\IntegrationTestCase;

/**
 * @uses \App\Controller\ContactController
 */
class ContactControllerTest extends IntegrationTestCase {

	/**
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();

		$this->session([
			'id' => '123',
		]);
		$this->configRequest([
			'environment' => [
				'REMOTE_ADDR' => '127.0.0.1',
			],
		]);

		Configure::write('Email.live', false);
		Configure::write('Config.adminEmail', 'admin@example.org');

		$this->disableErrorHandlerMiddleware();
	}

	/**
	 * Test index method
	 *
	 * @return void
	 */
	public function testIndex() {
		$this->get(['controller' => 'Contact', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * Test index method
	 *
	 * @return void
	 */
	public function testIndexPost() {
		$this->skipIf(true, 'TODO');

		$data = [
			'name' => '',
			'email' => '',
			'body' => '',
			'subject' => '',
		];
		$this->post(['controller' => 'Contact', 'action' => 'index'], $data);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * Test index method
	 *
	 * @return void
	 */
	public function testIndexPostValid() {
		$this->skipIf(true, 'TODO');

		$data = [
			'name' => 'Foo',
			'email' => 'foo@bar.de',
			'body' => 'Test',
			'subject' => 'Test',
		];
		$this->post(['controller' => 'Contact', 'action' => 'index'], $data);

		$this->assertResponseCode(302);
		$this->assertRedirect();
	}

}
