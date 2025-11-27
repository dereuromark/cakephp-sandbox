<?php
declare(strict_types=1);

namespace Sandbox\Test\TestCase\Model\Filter;

use Cake\TestSuite\TestCase;
use ReflectionClass;
use Sandbox\Model\Filter\SandboxPostsCollection;
use Sandbox\Model\Table\SandboxPostsTable;

/**
 * SandboxPostsCollection Test Case
 */
class SandboxPostsCollectionTest extends TestCase {

	/**
	 * @var array<string>
	 */
	protected array $fixtures = [
		'plugin.Sandbox.SandboxPosts',
	];

	/**
	 * Test that the filter collection is properly configured
	 *
	 * @return void
	 */
	public function testFilterCollectionIsUsed() {
		$table = $this->getTableLocator()->get('Sandbox.SandboxPosts');
		$this->assertInstanceOf(SandboxPostsTable::class, $table);

		// Verify the Search behavior is loaded with the correct collection class
		$behavior = $table->behaviors()->get('Search');
		$this->assertNotNull($behavior);

		$reflection = new ReflectionClass($behavior);
		$property = $reflection->getProperty('_collectionClass');
		$property->setAccessible(true);
		$collectionClass = $property->getValue($behavior);

		$this->assertSame(SandboxPostsCollection::class, $collectionClass);
	}

	/**
	 * Test that title filter works
	 *
	 * @return void
	 */
	public function testTitleFilter() {
		$table = $this->getTableLocator()->get('Sandbox.SandboxPosts');

		$query = $table->find('search', search: ['title' => 'test']);
		$sql = $query->sql();

		$this->assertStringContainsString('"title" LIKE', $sql);
	}

}
