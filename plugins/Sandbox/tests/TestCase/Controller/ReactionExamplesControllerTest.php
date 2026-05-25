<?php
declare(strict_types=1);

namespace Sandbox\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * @uses \Sandbox\Controller\ReactionExamplesController
 */
class ReactionExamplesControllerTest extends TestCase {

	use IntegrationTestTrait;

	/**
	 * @uses \Sandbox\Controller\ReactionExamplesController::index()
	 * @return void
	 */
	public function testIndex(): void {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'ReactionExamples', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @uses \Sandbox\Controller\ReactionExamplesController::api()
	 * @return void
	 */
	public function testApi(): void {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'ReactionExamples', 'action' => 'api']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * The widget posts a toggle back to the same action; the component persists it.
	 *
	 * @uses \Sandbox\Controller\ReactionExamplesController::index()
	 * @return void
	 */
	public function testToggleReactionPersists(): void {
		$this->disableErrorHandlerMiddleware();
		$this->enableCsrfToken();

		$posts = $this->fetchTable('Sandbox.SandboxPosts');
		$posts->ensureDemoData();
		$post = $posts->find()->orderBy(['SandboxPosts.id' => 'ASC'])->firstOrFail();

		$reactions = $this->fetchTable('Sandbox.SandboxReactions');
		$before = $reactions->find()->count();

		$this->post(
			['plugin' => 'Sandbox', 'controller' => 'ReactionExamples', 'action' => 'index'],
			[
				'reaction' => '🚀',
				'action' => 'toggle',
				'alias' => 'SandboxPosts',
				'id' => $post->id,
			],
		);

		$this->assertRedirect();
		$this->assertSame($before + 1, $reactions->find()->count());
	}

}
