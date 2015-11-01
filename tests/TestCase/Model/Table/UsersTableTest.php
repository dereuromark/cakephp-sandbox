<?php
namespace Test\TestCase\Model;

use App\Model\User;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * User Test Case
 *
 */
class UsersTableTest extends TestCase {

	/**
	 * Fixtures
	 *
	 * @var array
	 */
	public $fixtures = [
		'app.users'
	];

	/**
	 * SetUp method
	 *
	 * @return void
	 */
	public function setUp() {
		parent::setUp();
		$this->Users = TableRegistry::get('Users');
	}

	/**
	 * TearDown method
	 *
	 * @return void
	 */
	public function tearDown() {
		unset($this->Users);

		parent::tearDown();
	}

	public function testBasic() {
		$result = $this->Users->find()->first();
		$this->assertNotEmpty($result);
	}

}
