<?php

namespace App\Test\TestCase\View\Helper;

use App\View\Helper\NavigationHelper;
use Cake\TestSuite\TestCase;
use Cake\View\View;

class NavigationHelperTest extends TestCase {

	/**
	 * @var \App\View\Helper\NavigationHelper
	 */
	protected $NavigationHelper;

	/**
	 * setUp method
	 *
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();
		$view = new View();
		$this->NavigationHelper = new NavigationHelper($view);
	}

	/**
	 * tearDown method
	 *
	 * @return void
	 */
	public function tearDown(): void {
		unset($this->NavigationHelper);

		parent::tearDown();
	}

	/**
	 * Test link method
	 *
	 * @return void
	 */
	public function testLink() {
		$result = $this->NavigationHelper->link('foo', ['controller' => 'MyController', 'action' => 'myAction']);
		$this->assertNotEmpty($result);
	}

}
