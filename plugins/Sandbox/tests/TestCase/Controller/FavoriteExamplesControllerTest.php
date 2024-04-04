<?php
declare(strict_types=1);

namespace Sandbox\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * @uses \Sandbox\Controller\FavoriteExamplesController
 */
class FavoriteExamplesControllerTest extends TestCase {

	use IntegrationTestTrait;

	/**
	 * @var list<string>
	 */
	protected array $fixtures = [
		'plugin.Sandbox.SandboxPosts',
		'plugin.Sandbox.SandboxUsers',
		'plugin.Favorites.Favorites',
	];

	/**
	 * @uses \Sandbox\Controller\FavoriteExamplesController::index()
	 * @return void
	 */
	public function testIndex(): void {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'FavoriteExamples', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @uses \Sandbox\Controller\FavoriteExamplesController::star()
	 * @return void
	 */
	public function testStar(): void {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'FavoriteExamples', 'action' => 'star']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @uses \Sandbox\Controller\FavoriteExamplesController::like()
	 * @return void
	 */
	public function testLike(): void {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'FavoriteExamples', 'action' => 'like']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @uses \Sandbox\Controller\FavoriteExamplesController::favorite()
	 * @return void
	 */
	public function testFavorite(): void {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'FavoriteExamples', 'action' => 'favorite']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
