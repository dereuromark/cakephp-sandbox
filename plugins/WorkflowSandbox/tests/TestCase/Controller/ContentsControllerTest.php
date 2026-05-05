<?php
declare(strict_types=1);

namespace WorkflowSandbox\Test\TestCase\Controller;

use Shim\TestSuite\IntegrationTestCase;
use WorkflowSandbox\Test\Factory\ContentFactory;

/**
 * @uses \WorkflowSandbox\Controller\ContentsController
 */
class ContentsControllerTest extends IntegrationTestCase {

	/**
	 * @return void
	 */
	public function testIndex(): void {
		$this->get(['plugin' => 'WorkflowSandbox', 'controller' => 'Contents', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testAdd(): void {
		$this->get(['plugin' => 'WorkflowSandbox', 'controller' => 'Contents', 'action' => 'add']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testView(): void {
		$content = ContentFactory::new()->save();

		$this->get(['plugin' => 'WorkflowSandbox', 'controller' => 'Contents', 'action' => 'view', $content->id]);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testDelete(): void {
		$content = ContentFactory::new()->save();

		$this->post(['plugin' => 'WorkflowSandbox', 'controller' => 'Contents', 'action' => 'delete', $content->id]);

		$this->assertResponseCode(302);
		$this->assertRedirect(['action' => 'index']);
	}

	/**
	 * @return void
	 */
	public function testReset(): void {
		ContentFactory::new()->save();

		$this->post(['plugin' => 'WorkflowSandbox', 'controller' => 'Contents', 'action' => 'reset']);

		$this->assertResponseCode(302);
		$this->assertRedirect(['action' => 'index']);
	}

}
