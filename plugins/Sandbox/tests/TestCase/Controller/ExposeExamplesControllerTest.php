<?php

namespace Sandbox\Test\TestCase\Controller;

use Sandbox\Test\Factory\ExposedUserFactory;
use Shim\TestSuite\IntegrationTestCase;

/**
 * @uses \Sandbox\Controller\ExposeExamplesController
 */
class ExposeExamplesControllerTest extends IntegrationTestCase {

	/**
	 * @return void
	 */
	protected function setUp(): void {
		parent::setUp();

		ExposedUserFactory::new()->save();
	}

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
		$this->get(['plugin' => 'Sandbox', 'controller' => 'ExposeExamples', 'action' => 'users']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testView() {
		$this->disableErrorHandlerMiddleware();

		/** @var \Sandbox\Model\Entity\ExposedUser $user */
		$user = $this->fetchTable('Sandbox.ExposedUsers')->find()->firstOrFail();

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
		$user = $this->fetchTable('Sandbox.ExposedUsers')->find()->firstOrFail();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'ExposeExamples', 'action' => 'superimposedView', $user->uuid]);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testSuperimposedEdit() {
		$this->disableErrorHandlerMiddleware();

		/** @var \Sandbox\Model\Entity\ExposedUser $user */
		$user = $this->fetchTable('Sandbox.ExposedUsers')->find()->firstOrFail();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'ExposeExamples', 'action' => 'superimposedEdit', $user->uuid]);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
