<?php
declare(strict_types=1);

namespace Sandbox\Test\TestCase\Model\Filter;

use Cake\TestSuite\TestCase;
use ReflectionClass;
use Sandbox\Model\Filter\ProductsCollection;
use Sandbox\Model\Table\ProductsTable;

/**
 * ProductsCollection Test Case
 */
class ProductsCollectionTest extends TestCase {

	/**
	 * @var array<string>
	 */
	protected array $fixtures = [
		'plugin.Sandbox.SandboxProducts',
	];

	/**
	 * Test that the filter collection is properly configured
	 *
	 * @return void
	 */
	public function testFilterCollectionIsUsed() {
		$table = $this->getTableLocator()->get('Sandbox.Products');
		$this->assertInstanceOf(ProductsTable::class, $table);

		// Verify the Search behavior is loaded with the correct collection class
		$behavior = $table->behaviors()->get('Search');
		$this->assertNotNull($behavior);

		$reflection = new ReflectionClass($behavior);
		$property = $reflection->getProperty('_collectionClass');
		$collectionClass = $property->getValue($behavior);

		$this->assertSame(ProductsCollection::class, $collectionClass);
	}

	/**
	 * Test that title filter works
	 *
	 * @return void
	 */
	public function testTitleFilter() {
		$table = $this->getTableLocator()->get('Sandbox.Products');

		$query = $table->find('search', search: ['title' => 'test']);
		$sql = $query->sql();

		$this->assertStringContainsString('"title" LIKE', $sql);
	}

	/**
	 * Test that price range filter works
	 *
	 * @return void
	 */
	public function testPriceRangeFilter() {
		$table = $this->getTableLocator()->get('Sandbox.Products');

		$query = $table->find('search', search: ['price_min' => 10, 'price_max' => 50]);
		$sql = $query->sql();

		$this->assertStringContainsString('"price" >=', $sql);
		$this->assertStringContainsString('"price" <=', $sql);
	}

}
