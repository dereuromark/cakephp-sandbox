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
		$entity = $this->SandboxArticles->newEntity([]);
		$this->assertSame([
			'title' => ['_required' => 'This field is required'],
			'content' => ['_required' => 'This field is required'],
			'status' => ['_required' => 'This field is required'],
		], $entity->getErrors());

		$entity = $this->SandboxArticles->newEntity([
			'title' => str_repeat('x', 256),
			'content' => '',
			'status' => '',
		]);
		$this->assertArrayHasKey('maxLength', $entity->getError('title'));
		$this->assertArrayHasKey('_empty', $entity->getError('content'));
		$this->assertArrayHasKey('_empty', $entity->getError('status'));

		$entity = $this->SandboxArticles->newEntity([
			'title' => 'My title',
			'content' => 'Some content',
			'status' => 'published',
		]);
		$this->assertEmpty($entity->getErrors());
	}

}
