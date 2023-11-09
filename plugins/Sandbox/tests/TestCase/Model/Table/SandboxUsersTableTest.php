<?php
declare(strict_types=1);

namespace Sandbox\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use Sandbox\Model\Enum\UserStatus;
use Sandbox\Model\Table\SandboxUsersTable;

/**
 * Sandbox\Model\Table\SandboxUsersTable Test Case
 */
class SandboxUsersTableTest extends TestCase {

	/**
	 * Test subject
	 *
	 * @var \Sandbox\Model\Table\SandboxUsersTable
	 */
	protected $SandboxUsers;

	/**
	 * Fixtures
	 *
	 * @var array<string>
	 */
	protected array $fixtures = [
		'plugin.Sandbox.SandboxUsers',
	];

	/**
	 * @return void
	 */
	protected function setUp(): void {
		parent::setUp();
		$config = $this->getTableLocator()->exists('SandboxUsers') ? [] : ['className' => SandboxUsersTable::class];
		$this->SandboxUsers = $this->getTableLocator()->get('SandboxUsers', $config);
	}

	/**
	 * @return void
	 */
	protected function tearDown(): void {
		unset($this->SandboxUsers);

		parent::tearDown();
	}

	/**
	 * @return void
	 */
	public function testFind(): void {
		/** @var \App\Model\Entity\User $user */
		$user = $this->SandboxUsers->find()->firstOrFail();
		$this->assertInstanceOf(UserStatus::class, $user->status);
	}

}
