<?php

namespace App\Test\TestCase\View\Helper;

use App\View\Helper\SandboxHelper;
use Cake\TestSuite\TestCase;
use Cake\View\View;

class SandboxHelperTest extends TestCase {

	/**
	 * Test subject
	 *
	 * @var \App\View\Helper\SandboxHelper
	 */
	protected $SandboxHelper;

	/**
	 * setUp method
	 *
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();
		$view = new View();
		$this->SandboxHelper = new SandboxHelper($view);
	}

	/**
	 * tearDown method
	 *
	 * @return void
	 */
	public function tearDown(): void {
		unset($this->SandboxHelper);

		parent::tearDown();
	}

	/**
	 * Test pre method
	 *
	 * @return void
	 */
	public function testPre() {
		$result = $this->SandboxHelper->pre('Foo <Bar>');
		$expected = '<pre>&#039;Foo &lt;Bar&gt;&#039;</pre>';
		$this->assertSame($expected, $result);
	}

}
