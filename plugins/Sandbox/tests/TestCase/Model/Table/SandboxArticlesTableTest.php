<?php
declare(strict_types=1);

namespace Sandbox\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use Sandbox\Model\Table\SandboxArticlesTable;

class SandboxArticlesTableTest extends TestCase {

	/**
	 * Test subject
	 *
	 * @var \Sandbox\Model\Table\SandboxArticlesTable
	 */
	protected $SandboxArticles;

	/**
	 * @return void
	 */
	protected function setUp(): void {
		parent::setUp();
		$config = $this->getTableLocator()->exists('SandboxArticles') ? [] : ['className' => SandboxArticlesTable::class];
		$this->SandboxArticles = $this->getTableLocator()->get('SandboxArticles', $config);
	}

	/**
	 * @return void
	 */
	protected function tearDown(): void {
		unset($this->SandboxArticles);

		parent::tearDown();
	}

	/**
	 * @uses \Sandbox\Model\Table\SandboxArticlesTable::validationDefault()
	 * @return void
	 */
	public function testValidationDefault(): void {
		$this->markTestIncomplete('Not implemented yet.');
	}

}
