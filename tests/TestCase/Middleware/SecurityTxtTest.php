<?php

namespace App\Test\TestCase\Middleware;

use Shim\TestSuite\IntegrationTestCase;

/**
 * @uses \Setup\Middleware\SecurityTxtMiddleware
 */
class SecurityTxtTest extends IntegrationTestCase {

	/**
	 * The security.txt path is served by middleware before routing, so it can
	 * only be expressed as a string URL (there is no controller/action).
	 *
	 * @return void
	 */
	public function testWellKnownPath(): void {
		$this->get('/.well-known/security.txt');

		$this->assertResponseCode(200);
		$this->assertContentType('text/plain');
		$this->assertResponseContains('Contact: https://github.com/dereuromark/cakephp-sandbox/security/advisories/new');
		$this->assertResponseContains('Expires:');
	}

	/**
	 * @return void
	 */
	public function testRootFallback(): void {
		$this->get('/security.txt');

		$this->assertResponseCode(200);
		$this->assertResponseContains('Contact:');
	}

}
