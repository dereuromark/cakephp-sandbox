<?php
declare(strict_types = 1);

namespace Sandbox\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * Sandbox\Controller\MediaEmbedController Test Case
 *
 * @uses \Sandbox\Controller\MediaEmbedController
 */
class MediaEmbedControllerTest extends TestCase {

	use IntegrationTestTrait;

	/**
	 * Test index method
	 *
	 * @return void
	 */
	public function testIndex(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'MediaEmbed', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * Test bbcode method
	 *
	 * @return void
	 */
	public function testBbcode(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'MediaEmbed', 'action' => 'bbcode']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * Test hosts method
	 *
	 * @return void
	 */
	public function testHosts(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'MediaEmbed', 'action' => 'hosts']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
