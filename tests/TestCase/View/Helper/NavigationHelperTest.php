<?php

namespace App\Test\TestCase\View\Helper;

use App\View\Helper\NavigationHelper;
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
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

		Router::createRouteBuilder('/')->scope('/', function (RouteBuilder $routes) {
			$routes->fallbacks(DashedRoute::class);
		});
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
		$this->assertSame('<a href="/my-controller/my-action">foo</a>', $result);
	}

}
