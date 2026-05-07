<?php

namespace App\Test\TestCase\Controller\Admin;

use App\Test\Factory\RoleFactory;
use App\Test\Factory\UserFactory;
use Shim\TestSuite\IntegrationTestCase;

/**
 * App\Controller\Admin\UsersController Test Case
 *
 * @property \App\Model\Table\UsersTable $Users
 * @uses \App\Controller\Admin\UsersController
 */
class UsersControllerTest extends IntegrationTestCase {

	/**
	 * @var \App\Model\Entity\User
	 */
	protected $user;

	/**
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();

		RoleFactory::seedAll();
		$this->user = UserFactory::new()->asSuperadmin()->save();
		$this->session(['Auth' => $this->user]);
	}

	/**
	 * @return void
	 */
	public function testIndex() {
		$this->get(['prefix' => 'Admin', 'controller' => 'Users', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testAdd() {
		$this->get(['prefix' => 'Admin', 'controller' => 'Users', 'action' => 'add']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testEdit() {
		$this->get(['prefix' => 'Admin', 'controller' => 'Users', 'action' => 'edit', $this->user->id]);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testDelete() {
		$target = UserFactory::new()->save();

		$this->post(['prefix' => 'Admin', 'controller' => 'Users', 'action' => 'delete', $target->id]);

		$this->assertResponseCode(302);
		$this->assertRedirect(['action' => 'index']);
		$this->assertNull($this->fetchTable('Users')->find()->where(['id' => $target->id])->first());
	}

}
