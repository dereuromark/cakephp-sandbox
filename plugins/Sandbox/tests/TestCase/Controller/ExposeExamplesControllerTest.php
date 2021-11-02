<?php

namespace Sandbox\Test\TestCase\Controller;

use Cake\ORM\TableRegistry;
use Shim\TestSuite\IntegrationTestCase;

/**
 * @uses \Sandbox\Controller\ExposeExamplesController
 */
class ExposeExamplesControllerTest extends IntegrationTestCase {

	/**
	 * @var array<string>
	 */
	protected $fixtures = [
		'plugin.Sandbox.ExposedUsers',
	];

	/**
	 * @return void
	 */
	public function testIndex() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'ExposeExamples', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testUsers() {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'ExposeExamples', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testView() {
		$this->disableErrorHandlerMiddleware();

		/** @var \Sandbox\Model\Entity\ExposedUser $user */
		$user = TableRegistry::getTableLocator()->get('Sandbox.ExposedUsers')->find()->firstOrFail();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'ExposeExamples', 'action' => 'view', $user->uuid]);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}
	/**
	 * @return void
	 */
	public function testSuperimposedIndex() {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'ExposeExamples', 'action' => 'superimposedIndex']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testSuperimposedView() {
		$this->disableErrorHandlerMiddleware();

		/** @var \Sandbox\Model\Entity\ExposedUser $user */
		$user = TableRegistry::getTableLocator()->get('Sandbox.ExposedUsers')->find()->firstOrFail();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'ExposeExamples', 'action' => 'superimposedView', $user->uuid]);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
