<?php

namespace App\Test\TestCase\Controller;

use Cake\ORM\TableRegistry;
use Shim\TestSuite\IntegrationTestCase;

/**
 * App\Controller\AccountController Test Case
 *
 * @property \App\Model\Table\UsersTable $Users
 * @uses \App\Controller\AccountController
 */
class AccountControllerTest extends IntegrationTestCase {

	/**
	 * @var array
	 */
	protected array $fixtures = [
		'app.Users',
		'app.Roles',
	];

	/**
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();
	}

	/**
	 * @return void
	 */
	public function tearDown(): void {
		parent::tearDown();

		TableRegistry::clear();
	}

	/**
	 * @return void
	 */
	public function testLogin() {
		$this->disableErrorHandlerMiddleware();

		$this->get(['controller' => 'Account', 'action' => 'login']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testLoginLoggedIn() {
		$data = [
			'Auth' => ['User' => ['id' => 1, 'role_id' => 1]],
		];
		$this->session($data);

		$this->get(['controller' => 'Account', 'action' => 'login']);
		$this->assertResponseCode(302);
		$this->assertRedirect(['controller' => 'Account', 'action' => 'index']);

		$this->assertSession('info', 'Flash.flash.0.type');

		$expected = 'The page you tried to access is not relevant if you are already logged in. Redirected to main page.';
		$this->assertSession($expected, 'Flash.flash.0.message');
	}

	/**
	 * @return void
	 */
	public function testLoginPostInvalidData() {
		$this->disableErrorHandlerMiddleware();

		$data = [];
		$this->post(['controller' => 'Account', 'action' => 'login'], $data);
		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testLoginPostValidData() {
		$data = [
			'username' => 'admin',
			'email' => 'admin@example.com',
			'pwd' => '123456',
		];
		$Users = TableRegistry::get('Users');
		$Users->addBehavior('Tools.Passwordable', ['confirm' => false]);
		$user = $Users->newEntity($data);
		$result = $Users->save($user);
		$this->assertTrue((bool)$result);
		$Users->removeBehavior('Passwordable');

		$data = [
			'login' => 'admin', 'password' => '123456',
		];
		$this->post(['controller' => 'Account', 'action' => 'login'], $data);
		$this->assertResponseCode(302);
		$this->assertRedirect('/account');
	}

	/**
	 * @return void
	 */
	public function testLoginPostValidDataEmail() {
		$data = [
			'username' => 'admin',
			'email' => 'admin@example.com',
			'pwd' => '123456',
		];
		$Users = TableRegistry::get('Users');
		$Users->addBehavior('Tools.Passwordable', ['confirm' => false]);
		$user = $Users->newEntity($data);
		$result = $Users->save($user);
		$this->assertTrue((bool)$result);
		$Users->removeBehavior('Passwordable');

		$data = [
			'login' => 'admin@example.com', 'password' => '123456',
		];
		$this->post(['controller' => 'Account', 'action' => 'login'], $data);
		$this->assertResponseCode(302);
		$this->assertRedirect('/account');
	}

	/**
	 * @return void
	 */
	public function testLoginPostValidDataReferrer() {
		$data = [
			'username' => 'admin',
			'email' => 'admin@example.com',
			'pwd' => '123456',
		];
		$Users = TableRegistry::get('Users');
		$Users->addBehavior('Tools.Passwordable', ['confirm' => false]);
		$user = $Users->newEntity($data);
		$result = $Users->save($user);
		$this->assertTrue((bool)$result);
		$Users->removeBehavior('Passwordable');

		$data = [
			'login' => 'admin', 'password' => '123456',
		];
		$this->post(['controller' => 'Account', 'action' => 'login', '?' => ['redirect' => '/somewhere']], $data);
		$this->assertResponseCode(302);
		$this->assertRedirect('/somewhere');
	}

	/**
	 * @return void
	 */
	public function testLogout() {
		$session = ['Auth' => ['User' => ['id' => '1', 'role_id' => 1]]];
		$this->session($session);

		$this->get(['controller' => 'Account', 'action' => 'logout']);
		$this->assertResponseCode(302);
		$this->assertRedirect('/');
	}

	/**
	 * @return void
	 */
	public function testLostPassword() {
		$this->skipIf(true, 'FIXME');

		$this->get(['controller' => 'Account', 'action' => 'lostPassword']);
		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testChangePasswordInvalid() {
		$this->get(['controller' => 'Account', 'action' => 'changePassword']);
		$this->assertResponseCode(302);
		$this->assertRedirect(['controller' => 'Account', 'action' => 'lostPassword']);
	}

	/**
	 * @return void
	 */
	public function testChangePassword() {
		$session = ['Auth' => ['Tmp' => ['id' => '1']]];
		$this->session($session);

		$this->get(['controller' => 'Account', 'action' => 'changePassword']);
		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testChangePasswordPost() {
		$this->skipIf(true); // not needed right now

		$Users = TableRegistry::get('Users');
		$username = $Users->field('username');

		$session = ['Auth' => ['Tmp' => ['id' => '1']]];
		$this->session($session);

		$data = [
			'pwd' => '123456',
			'pwd_repeat' => '123456',
		];
		$this->post(['controller' => 'Account', 'action' => 'changePassword'], $data);

		if ($this->_response->statusCode() !== 302) {
			debug($this->_response->body());
		}

		$this->assertResponseCode(302);
		$this->assertRedirect(['action' => 'login', '?' => ['username' => $username]]);

		$result = $this->_requestSession->read('FlashMessage.success');
		$this->assertSame([__('new pw saved - you may now log in')], $result);
	}

	/**
	 * @return void
	 */
	public function testRegister() {
		$this->get(['controller' => 'Account', 'action' => 'register']);
		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testEdit() {
		$data = [
			'Auth' => ['User' => ['id' => 1, 'role_id' => 1]],
		];
		$this->session($data);

		$this->get(['controller' => 'Account', 'action' => 'edit']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
