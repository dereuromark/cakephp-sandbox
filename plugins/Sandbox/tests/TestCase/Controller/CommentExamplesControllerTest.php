<?php
declare(strict_types=1);

namespace Sandbox\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * @uses \Sandbox\Controller\CommentExamplesController
 */
class CommentExamplesControllerTest extends TestCase {

	use IntegrationTestTrait;

	/**
	 * @var list<string>
	 */
	protected array $fixtures = [
		'plugin.Sandbox.SandboxPosts',
		'plugin.Comments.Comments',
	];

	/**
	 * @uses \Sandbox\Controller\CommentExamplesController::index()
	 * @return void
	 */
	public function testIndex(): void {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'CommentExamples', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @uses \Sandbox\Controller\CommentExamplesController::basic()
	 * @return void
	 */
	public function testBasic(): void {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'CommentExamples', 'action' => 'basic']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @uses \Sandbox\Controller\CommentExamplesController::basic()
	 * @return void
	 */
	public function testBasicPostInvalid(): void {
		$this->disableErrorHandlerMiddleware();

		$this->post(['plugin' => 'Sandbox', 'controller' => 'CommentExamples', 'action' => 'basic'], []);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @uses \Sandbox\Controller\CommentExamplesController::basic()
	 * @return void
	 */
	public function testBasicPostValid(): void {
		$this->disableErrorHandlerMiddleware();

		$data = [
			'comment' => 'FooBar',
			'name' => 'Foo',
			'email' => 'foo@bar.de',
		];
		$this->post(['plugin' => 'Sandbox', 'controller' => 'CommentExamples', 'action' => 'basic'], $data);

		$this->assertResponseCode(302);
		$this->assertRedirect(['plugin' => 'Sandbox', 'controller' => 'CommentExamples', 'action' => 'basic']);
	}

}
