<?php

namespace App\Test\TestCase\Controller;

use App\Controller\AccountController;
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
		$this->get(array('controller' => 'Account', 'action' => 'login'));
		file_put_contents(TMP . 'error.html', $this->_response->body());
		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testLoginLoggedIn() {
		$data = array(
			'Auth' => array('User' => array('id' => 1, 'role_id' => 1))
		);
		$this->session($data);

		$this->get(array('controller' => 'Account', 'action' => 'login'));
		$this->assertResponseCode(302);
		$this->assertRedirect(['controller' => 'Account', 'action' => 'index']);
	}

	/**
	 * Test index method
	 *
	 * @return void
	 */
	public function testLoginPostInvalidData() {
		$this->post(array('controller' => 'Account', 'action' => 'login'));
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

		$data = array(
			'username' => 'admin',
			'email' => 'admin@example.com',
			'pwd' => '123456'
		);
		$this->Users = TableRegistry::get('Users');
		$this->Users->addBehavior('Tools.Passwordable', array('confirm' => false));
		$user = $this->Users->newEntity($data);
		$result = $this->Users->save($user);
		$this->assertTrue((bool)$result);
		$this->Users->removeBehavior('Passwordable');

		$data = array(
			'login' => 'admin', 'password' => '123456'
		);
		$this->post(array('controller' => 'Account', 'action' => 'login'), $data);
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

		$data = array(
			'username' => 'admin',
			'email' => 'admin@example.com',
			'pwd' => '123456'
		);
		$this->Users = TableRegistry::get('Users');
		$this->Users->addBehavior('Tools.Passwordable', array('confirm' => false));
		$user = $this->Users->newEntity($data);
		$result = $this->Users->save($user);
		$this->assertTrue((bool)$result);
		$this->Users->removeBehavior('Passwordable');

		$data = array(
			'login' => 'admin@example.com', 'password' => '123456'
		);
		$this->post(array('controller' => 'Account', 'action' => 'login'), $data);
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

		$session = array('Auth' => array('redirect' => '/attendance'));
		$this->session($session);

		$data = array(
			'username' => 'admin',
			'email' => 'admin@example.com',
			'pwd' => '123456'
		);
		$this->Users = TableRegistry::get('Users');
		$this->Users->addBehavior('Tools.Passwordable', array('confirm' => false));
		$user = $this->Users->newEntity($data);
		$result = $this->Users->save($user);
		$this->assertTrue((bool)$result);
		$this->Users->removeBehavior('Passwordable');

		$data = array(
			'login' => 'admin', 'password' => '123456'
		);
		$this->post(array('controller' => 'Account', 'action' => 'login'), $data);
		$this->assertResponseCode(302);
		$this->assertRedirect('/attendance');
	}

	/**
	 * AccountControllerTest::testLogout()
	 *
	 * @return void
	 */
	public function testLogout() {
		$session = array('Auth' => array('User' => array('id' => '1')));
		$this->session($session);

		$this->get(array('controller' => 'Account', 'action' => 'logout'));
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

		$this->get(array('controller' => 'Account', 'action' => 'lost_password'));
		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * AccountControllerTest::testLogout()
	 *
	 * @return void
	 */
	public function testChangePasswordInvalid() {
		$this->get(array('controller' => 'Account', 'action' => 'change_password'));
		$this->assertResponseCode(302);
		$this->assertRedirect(array('controller' => 'Account', 'action' => 'lost_password'));
	}

	/**
	 * AccountControllerTest::testLogout()
	 *
	 * @return void
	 */
	public function testChangePassword() {
		$session = array('Auth' => array('Tmp' => array('id' => '1')));
		$this->session($session);

		$this->get(array('controller' => 'Account', 'action' => 'change_password'));
		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * AccountControllerTest::testLogout()
	 *
	 * @return void
	 */
	public function testChangePasswordPost() {
		$this->Users = TableRegistry::get('Users');
		$username = $this->Users->field('username');

		$session = array('Auth' => array('Tmp' => array('id' => '1')));
		$this->session($session);

		$data = array(
			'pwd' => '123456',
			'pwd_repeat' => '123456'
		);
		$this->post(array('controller' => 'Account', 'action' => 'change_password'), $data);
		$this->assertResponseCode(302);
		$this->assertRedirect(array('action' => 'login', '?' => array('username' => $username)));

		$result = $this->_requestSession->read('FlashMessage.success');
		$this->assertSame(array(__('new pw saved - you may now log in')), $result);
	}

	/**
	 * AccountControllerTest::testLogout()
	 *
	 * @return void
	 */
	public function testRegister() {
		$this->get(array('controller' => 'Account', 'action' => 'register'));
		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
