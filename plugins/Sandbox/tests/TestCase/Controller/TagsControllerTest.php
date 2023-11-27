<?php
declare(strict_types = 1);

namespace Sandbox\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * Sandbox\Controller\TagsController Test Case
 *
 * @uses \Sandbox\Controller\TagsController
 */
class TagsControllerTest extends TestCase {

	use IntegrationTestTrait;

	/**
	 * @var array
	 */
	protected array $fixtures = [
		'plugin.Sandbox.SandboxCategories',
		'plugin.Sandbox.SandboxPosts',
		'plugin.Tags.Tags',
		'plugin.Tags.Tagged',
	];

	/**
	 * Test index method
	 *
	 * @return void
	 */
	public function testIndex(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Tags', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * Test select method
	 *
	 * @return void
	 */
	public function testSelect(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Tags', 'action' => 'select']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * Test search method
	 *
	 * @return void
	 */
	public function testSearch(): void {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'Tags', 'action' => 'search']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testSearchFiltering(): void {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'Tags', 'action' => 'search', '?' => ['tag' => 'foo']]);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * Test cloud method
	 *
	 * @return void
	 */
	public function testCloud(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Tags', 'action' => 'cloud']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
