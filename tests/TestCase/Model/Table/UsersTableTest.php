<?php

namespace App\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;

/**
 * User Test Case
 */
class UsersTableTest extends TestCase {

	/**
	 * Fixtures
	 *
	 * @var array
	 */
	protected array $fixtures = [
		'app.Users',
	];

	/**
	 * @var \App\Model\Table\UsersTable
	 */
	protected $Users;

	/**
	 * SetUp method
	 *
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();
		$this->Users = $this->fetchTable('Users');
	}

	/**
	 * TearDown method
	 *
	 * @return void
	 */
	public function tearDown(): void {
		unset($this->Users);

		parent::tearDown();
	}

	/**
	 * @return void
	 */
	public function testBasic() {
		$result = $this->Users->find()->first();
		$this->assertNotEmpty($result);
	}

}
