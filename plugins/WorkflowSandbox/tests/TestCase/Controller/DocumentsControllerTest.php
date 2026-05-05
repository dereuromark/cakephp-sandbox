<?php
declare(strict_types=1);

namespace WorkflowSandbox\Test\TestCase\Controller;

use Shim\TestSuite\IntegrationTestCase;
use WorkflowSandbox\Test\Factory\DocumentFactory;

/**
 * @uses \WorkflowSandbox\Controller\DocumentsController
 */
class DocumentsControllerTest extends IntegrationTestCase {

	/**
	 * @return void
	 */
	public function testIndex(): void {
		$this->get(['plugin' => 'WorkflowSandbox', 'controller' => 'Documents', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testAdd(): void {
		$this->get(['plugin' => 'WorkflowSandbox', 'controller' => 'Documents', 'action' => 'add']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testView(): void {
		$document = DocumentFactory::new()->save();

		$this->get(['plugin' => 'WorkflowSandbox', 'controller' => 'Documents', 'action' => 'view', $document->id]);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testDelete(): void {
		$document = DocumentFactory::new()->save();

		$this->post(['plugin' => 'WorkflowSandbox', 'controller' => 'Documents', 'action' => 'delete', $document->id]);

		$this->assertResponseCode(302);
		$this->assertRedirect(['action' => 'index']);
	}

	/**
	 * @return void
	 */
	public function testReset(): void {
		DocumentFactory::new()->save();

		$this->post(['plugin' => 'WorkflowSandbox', 'controller' => 'Documents', 'action' => 'reset']);

		$this->assertResponseCode(302);
		$this->assertRedirect(['action' => 'index']);
	}

}
