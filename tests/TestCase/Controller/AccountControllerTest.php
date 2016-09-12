<?php

namespace App\Test\TestCase\Controller;

use Cake\ORM\TableRegistry;
use Tools\TestSuite\IntegrationTestCase;

/**
 * App\Controller\AccountController Test Case
 */
class AccountControllerTest extends IntegrationTestCase {

	/**
	 * Fixtures
	 *
	 * @var array
	 */
	public $fixtures = ['Users' => 'app.users', 'Roles' => 'app.roles'];

	public function setUp() {
		parent::setUp();
	}

	public function tearDown() {
		parent::tearDown();

		TableRegistry::clear();
	}

	/**
	 * Test index method
	 *
	 * @return void
	 */
	public function testLoginX() {
		$this->get(['controller' => 'Account', 'action' => 'login']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testLoginLoggedIn() {
		$data = [
			'Auth' => ['User' => ['id' => 1, 'role_id' => 1]]
		];
		$this->session($data);

		$this->get(['controller' => 'Account', 'action' => 'login']);
		$this->assertResponseCode(302);
		$this->assertRedirect(['controller' => 'Account', 'action' => 'index']);

		$this->assertSession(['The page you tried to access is not relevant if you are already logged in. Redirected to main page.'], 'FlashMessage.info');
	}

	/**
	 * Test index method
	 *
	 * @return void
	 */
	public function testLoginPostInvalidData() {
		$this->post(['controller' => 'Account', 'action' => 'login']);
		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * Test index method
	 *
	 * @return void
	 */
	public function testLoginPostValidData() {
		$this->skipIf(true);

		$data = [
			'username' => 'admin',
			'email' => 'admin@example.com',
			'pwd' => '123456'
		];
		$this->Users = TableRegistry::get('Users');
		$this->Users->addBehavior('Tools.Passwordable', ['confirm' => false]);
		$user = $this->Users->newEntity($data);
		$result = $this->Users->save($user);
		$this->assertTrue((bool)$result);
		$this->Users->removeBehavior('Passwordable');

		$data = [
			'login' => 'admin', 'password' => '123456'
		];
		$this->post(['controller' => 'Account', 'action' => 'login'], $data);
		$this->assertResponseCode(302);
		$this->assertRedirect('/');
	}

	/**
	 * Test index method
	 *
	 * @return void
	 */
	public function testLoginPostValidDataEmail() {
		$this->skipIf(true);

		$data = [
			'username' => 'admin',
			'email' => 'admin@example.com',
			'pwd' => '123456'
		];
		$this->Users = TableRegistry::get('Users');
		$this->Users->addBehavior('Tools.Passwordable', ['confirm' => false]);
		$user = $this->Users->newEntity($data);
		$result = $this->Users->save($user);
		$this->assertTrue((bool)$result);
		$this->Users->removeBehavior('Passwordable');

		$data = [
			'login' => 'admin@example.com', 'password' => '123456'
		];
		$this->post(['controller' => 'Account', 'action' => 'login'], $data);
		$this->assertResponseCode(302);
		$this->assertRedirect('/');
	}

	/**
	 * Test index method
	 *
	 * @return void
	 */
	public function testLoginPostValidDataReferrer() {
		$this->skipIf(true);

		$session = ['Auth' => ['redirect' => '/attendance']];
		$this->session($session);

		$data = [
			'username' => 'admin',
			'email' => 'admin@example.com',
			'pwd' => '123456'
		];
		$this->Users = TableRegistry::get('Users');
		$this->Users->addBehavior('Tools.Passwordable', ['confirm' => false]);
		$user = $this->Users->newEntity($data);
		$result = $this->Users->save($user);
		$this->assertTrue((bool)$result);
		$this->Users->removeBehavior('Passwordable');

		$data = [
			'login' => 'admin', 'password' => '123456'
		];
		$this->post(['controller' => 'Account', 'action' => 'login'], $data);
		$this->assertResponseCode(302);
		$this->assertRedirect('/attendance');
	}

	/**
	 * AccountControllerTest::testLogout()
	 *
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
	 * AccountControllerTest::testLogout()
	 *
	 * @return void
	 */
	public function testLostPassword() {
		$this->skipIf(true);

		$this->get(['controller' => 'Account', 'action' => 'lostPassword']);
		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * AccountControllerTest::testLogout()
	 *
	 * @return void
	 */
	public function testChangePasswordInvalid() {
		$this->get(['controller' => 'Account', 'action' => 'changePassword']);
		$this->assertResponseCode(302);
		$this->assertRedirect(['controller' => 'Account', 'action' => 'lostPassword']);
	}

	/**
	 * AccountControllerTest::testLogout()
	 *
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
	 * AccountControllerTest::testLogout()
	 *
	 * @return void
	 */
	public function testChangePasswordPost() {
		$this->skipIf(true); // not needed right now

		$this->Users = TableRegistry::get('Users');
		$username = $this->Users->field('username');

		$session = ['Auth' => ['Tmp' => ['id' => '1']]];
		$this->session($session);

		$data = [
			'pwd' => '123456',
			'pwd_repeat' => '123456'
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
	 * AccountControllerTest::testLogout()
	 *
	 * @return void
	 */
	public function testRegister() {
		$this->get(['controller' => 'Account', 'action' => 'register']);
		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
