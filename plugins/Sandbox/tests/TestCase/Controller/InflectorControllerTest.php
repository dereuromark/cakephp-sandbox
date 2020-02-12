<?php

namespace Sandbox\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * Sandbox\Controller\InflectorController Test Case
 *
 * @uses \Sandbox\Controller\InflectorController
 */
class InflectorControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * @return void
     */
    public function testIndex(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Inflector', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
    }

	/**
	 * @return void
	 */
	public function testIndexQuery(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'Inflector', 'action' => 'index', '?' => ['string' => 'FooBar']]);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

}
