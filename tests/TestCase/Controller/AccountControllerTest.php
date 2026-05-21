<?php

namespace App\Test\TestCase\Controller;

use App\Test\Factory\RoleFactory;
use App\Test\Factory\UserFactory;
use Cake\Mailer\TransportFactory;
use Shim\TestSuite\IntegrationTestCase;

/**
 * App\Controller\AccountController Test Case
 *
 * @uses \App\Controller\AccountController
 * @property \App\Model\Table\UsersTable $Users
 */
class AccountControllerTest extends IntegrationTestCase {

	/**
	 * @return void
	 */
	protected function setUp(): void {
		parent::setUp();
		RoleFactory::seedAll();
	}

	/**
	 * @return void
	 */
	public function testIndex() {
		$user = UserFactory::new()->build();
		$this->session(['Auth' => $user]);

		$this->get(['controller' => 'Account', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
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
		$user = UserFactory::new()->build();
		$this->session(['Auth' => $user]);

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
		$user = UserFactory::new(['username' => 'logintest'])->save();

		$this->post(['controller' => 'Account', 'action' => 'login'], [
			'login' => $user->username,
			'password' => '123',
		]);
		$this->assertResponseCode(302);
		$this->assertRedirect(['controller' => 'Account', 'action' => 'index']);
	}

	/**
	 * @return void
	 */
	public function testLoginPostValidDataEmail() {
		$user = UserFactory::new(['email' => 'logintest@example.com'])->save();

		$this->post(['controller' => 'Account', 'action' => 'login'], [
			'login' => $user->email,
			'password' => '123',
		]);
		$this->assertResponseCode(302);
		$this->assertRedirect(['controller' => 'Account', 'action' => 'index']);
	}

	/**
	 * @return void
	 */
	public function testLoginPostValidDataReferrer() {
		$user = UserFactory::new(['username' => 'logintest'])->save();

		$this->post(['controller' => 'Account', 'action' => 'login', '?' => ['redirect' => '/somewhere']], [
			'login' => $user->username,
			'password' => '123',
		]);
		$this->assertResponseCode(302);
		$this->assertRedirectContains('/somewhere');
	}

	/**
	 * @return void
	 */
	public function testLogout() {
		$user = UserFactory::new()->build();
		$this->session(['Auth' => $user]);

		$this->get(['controller' => 'Account', 'action' => 'logout']);
		$this->assertResponseCode(302);
		$this->assertRedirect(['controller' => 'Overview', 'action' => 'index']);
	}

	/**
	 * @return void
	 */
	public function testLostPassword() {
		$this->get(['controller' => 'Account', 'action' => 'lostPassword']);
		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * POST with a matching email triggers token creation, email delivery, and a redirect back.
	 *
	 * @return void
	 */
	public function testLostPasswordPostValidEmail() {
		$this->setupDebugEmailTransport();
		$user = UserFactory::new(['email' => 'lost@example.com'])->save();

		$this->enableRetainFlashMessages();
		$this->post(['controller' => 'Account', 'action' => 'lostPassword'], [
			'Form' => ['login' => $user->email],
		]);

		$this->assertResponseCode(302);
		$this->assertRedirect(['controller' => 'Account', 'action' => 'lost_password']);
		$this->assertFlashMessage(__('In a third step you will then be able to change your password.'));

		$tokensTable = $this->fetchTable('Tools.Tokens');
		$token = $tokensTable->find()
			->where(['user_id' => $user->id, 'type' => 'reset_pwd'])
			->first();
		static::assertNotNull($token);
	}

	/**
	 * POST with a non-existent email shows an error flash and re-renders the form.
	 *
	 * @return void
	 */
	public function testLostPasswordPostUnknownEmail() {
		$this->enableRetainFlashMessages();
		$this->post(['controller' => 'Account', 'action' => 'lostPassword'], [
			'Form' => ['login' => 'nobody@example.com'],
		]);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
		$this->assertFlashMessage('No account has been found for nobody@example.com');
	}

	/**
	 * POST with an invalid reset key shows the "Invalid Key" flash.
	 *
	 * @return void
	 */
	public function testLostPasswordPostInvalidKey() {
		$this->enableRetainFlashMessages();
		$this->post(['controller' => 'Account', 'action' => 'lostPassword'], [
			'Form' => ['key' => 'not-a-real-key'],
		]);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
		$this->assertFlashMessage(__('Invalid Key'));
	}

	/**
	 * POST with a valid reset key stores the user id in the session and redirects to change_password.
	 *
	 * @return void
	 */
	public function testLostPasswordPostValidKey() {
		$user = UserFactory::new()->save();
		/** @var \Tools\Model\Table\TokensTable $tokensTable */
		$tokensTable = $this->fetchTable('Tools.Tokens');
		$key = $tokensTable->newKey('reset_pwd', null, (string)$user->id);

		$this->post(['controller' => 'Account', 'action' => 'lostPassword'], [
			'Form' => ['key' => $key],
		]);

		$this->assertResponseCode(302);
		$this->assertRedirect(['controller' => 'Account', 'action' => 'change_password']);

		// The redirect to change_password only happens after the elseif ($token) branch
		// runs, which also marks the token as spent.
		$spent = $tokensTable->find()->where(['token_key' => $key])->firstOrFail();
		static::assertSame(1, (int)$spent->get('used'));
	}

	/**
	 * Configures a Debug email transport so deliver() doesn't try to hit the real mail backend.
	 *
	 * @return void
	 */
	protected function setupDebugEmailTransport(): void {
		TransportFactory::drop('default');
		TransportFactory::setConfig('default', ['className' => 'Debug']);
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
		$user = UserFactory::new()->save();
		$this->session(['Auth' => ['Tmp' => ['id' => (string)$user->id]]]);

		$this->get(['controller' => 'Account', 'action' => 'changePassword']);
		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testChangePasswordPost() {
		$this->skipIf(true); // not needed right now

		$Users = $this->fetchTable('Users');
		$username = $Users->field('username');

		$session = ['Auth' => ['Tmp' => ['id' => '1']]];
		$this->session($session);

		$data = [
			'pwd' => '123456',
			'pwd_repeat' => '123456',
		];
		$this->post(['controller' => 'Account', 'action' => 'changePassword'], $data);

		if ($this->_response->getStatusCode() !== 302) {
			debug($this->_response->getBody()->getContents());
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
		$user = UserFactory::new()->save();
		$this->session(['Auth' => $user]);

		$this->get(['controller' => 'Account', 'action' => 'edit']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testDelete() {
		$user = UserFactory::new()->save();
		$this->session(['Auth' => $user]);

		$this->post(['controller' => 'Account', 'action' => 'delete']);

		$this->assertResponseCode(302);
		$this->assertNull($this->fetchTable('Users')->find()->where(['id' => $user->id])->first());
	}

}
