<?php

namespace App\Test\TestCase\View\Helper;

use App\View\Helper\NavigationHelper;
use Cake\TestSuite\TestCase;
use Cake\View\View;

class NavigationHelperTest extends TestCase {

	/**
	 * @var \App\View\Helper\NavigationHelper
	 */
	public $NavigationHelper;

	/**
	 * setUp method
	 *
	 * @return void
	 */
	public function setUp() {
		parent::setUp();
		$view = new View();
		$this->NavigationHelper = new NavigationHelper($view);
	}

	/**
	 * tearDown method
	 *
	 * @return void
	 */
	public function tearDown() {
		unset($this->NavigationHelper);

		parent::tearDown();
	}

	/**
	 * Test link method
	 *
	 * @return void
	 */
	public function testLink() {
		$result = $this->NavigationHelper->link('foo', ['controller' => 'MyController', 'action' => 'foo']);
		$this->assertSame('<a href="/my-controller/foo">foo</a>', $result);
	}

}
