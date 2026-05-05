<?php

namespace AuthSandbox\Test\TestCase\Controller;

use App\Test\Factory\RoleFactory;
use App\Test\Factory\UserFactory;
use Shim\TestSuite\IntegrationTestCase;

/**
 * App\Controller\AuthSandboxController Test Case
 *
 * @uses \AuthSandbox\Controller\AuthSandboxController
 */
class AuthSandboxControllerTest extends IntegrationTestCase {

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
		$this->get(['plugin' => 'AuthSandbox', 'controller' => 'AuthSandbox', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testLogin() {
		$this->get(['plugin' => 'AuthSandbox', 'controller' => 'AuthSandbox', 'action' => 'login']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testForAll() {
		$user = UserFactory::new()->save();
		$this->session(['Auth' => $user]);

		$this->get(['plugin' => 'AuthSandbox', 'controller' => 'AuthSandbox', 'action' => 'forAll']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testForMods() {
		$user = UserFactory::new()->asMod()->save();
		$this->session(['Auth' => $user]);

		$this->get(['plugin' => 'AuthSandbox', 'controller' => 'AuthSandbox', 'action' => 'forMods']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testRegister() {
		$this->get(['plugin' => 'AuthSandbox', 'controller' => 'AuthSandbox', 'action' => 'register']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * @return void
	 */
	public function testLogout() {
		$user = UserFactory::new()->save();
		$this->session(['Auth' => $user]);

		$this->get(['plugin' => 'AuthSandbox', 'controller' => 'AuthSandbox', 'action' => 'logout']);

		$this->assertResponseCode(302);
	}

	/**
	 * forMods is mod-only; a plain user must be redirected.
	 *
	 * @return void
	 */
	public function testForModsAsUserRedirects() {
		$user = UserFactory::new()->save();
		$this->session(['Auth' => $user]);

		$this->get(['plugin' => 'AuthSandbox', 'controller' => 'AuthSandbox', 'action' => 'forMods']);

		$this->assertResponseCode(302);
		$this->assertRedirect();
	}

	/**
	 * forAll requires any authenticated user; anonymous request must be redirected.
	 *
	 * @return void
	 */
	public function testForAllAnonymousRedirects() {
		$this->get(['plugin' => 'AuthSandbox', 'controller' => 'AuthSandbox', 'action' => 'forAll']);

		$this->assertResponseCode(302);
		$this->assertRedirect();
	}

}
