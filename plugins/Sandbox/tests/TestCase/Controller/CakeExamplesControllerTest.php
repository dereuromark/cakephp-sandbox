<?php

namespace Sandbox\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * Sandbox\Controller\CakeExamplesController Test Case
 *
 * @uses \Sandbox\Controller\CakeExamplesController
 */
class CakeExamplesControllerTest extends TestCase {

	use IntegrationTestTrait;

	/**
	 * Fixtures
	 *
	 * @var array
	 */
	protected array $fixtures = [
		'plugin.Sandbox.SandboxAnimals',
	];

	/**
	 * Test index method
	 *
	 * @return void
	 */
	public function testIndex(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'CakeExamples', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * Test queryStrings method
	 *
	 * @return void
	 */
	public function testQueryStrings(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'CakeExamples', 'action' => 'queryStrings']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * Test merge method
	 *
	 * @return void
	 */
	public function testMerge(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'CakeExamples', 'action' => 'merge']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * Test i18n method
	 *
	 * @return void
	 */
	public function testI18n(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'CakeExamples', 'action' => 'i18n']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * Test validation method
	 *
	 * @return void
	 */
	public function testValidation(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'CakeExamples', 'action' => 'validation']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * Test validation method
	 *
	 * @return void
	 */
	public function testValidationPostInvalid(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'CakeExamples', 'action' => 'validation']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * Test validation method
	 *
	 * @return void
	 */
	public function testValidationPostValid(): void {
		$data = [
			'name' => 'Mouse',
			'confirm' => true,
		];
		$this->post(['plugin' => 'Sandbox', 'controller' => 'CakeExamples', 'action' => 'validation'], $data);

		$this->assertResponseCode(302);
		$this->assertRedirect();
	}

}
