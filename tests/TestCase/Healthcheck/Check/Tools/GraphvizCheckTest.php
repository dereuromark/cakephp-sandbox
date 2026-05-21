<?php

namespace App\Test\TestCase\Healthcheck\Check\Tools;

use App\Healthcheck\Check\Tools\GraphvizCheck;
use Shim\TestSuite\TestCase;

class GraphvizCheckTest extends TestCase {

	/**
	 * @return void
	 */
	public function testDomain(): void {
		$check = new GraphvizCheck();
		static::assertSame('Tools', $check->domain());
	}

	/**
	 * The check shells out to `dot` — behavior depends on the host. Either outcome is
	 * acceptable here; we just verify the check produces a defined state and a message.
	 *
	 * @return void
	 */
	public function testCheck(): void {
		$check = new GraphvizCheck();
		$check->check();

		static::assertNotEmpty($check->infoMessage());
	}

}
