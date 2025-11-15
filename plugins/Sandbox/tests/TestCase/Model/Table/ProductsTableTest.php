<?php
declare(strict_types=1);

namespace Sandbox\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use Sandbox\Model\Table\ProductsTable;

/**
 * Sandbox\Model\Table\SandboxProductsTable Test Case
 */
class ProductsTableTest extends TestCase {

	/**
	 * Test subject
	 *
	 * @var \Sandbox\Model\Table\ProductsTable
	 */
	protected $Products;

	/**
	 * Fixtures
	 *
	 * @var list<string>
	 */
	protected array $fixtures = [
		'plugin.Sandbox.SandboxProducts',
	];

	/**
	 * setUp method
	 *
	 * @return void
	 */
	protected function setUp(): void {
		parent::setUp();
		$config = $this->getTableLocator()->exists('Sandbox.Products') ? [] : ['className' => ProductsTable::class];
		$this->Products = $this->getTableLocator()->get('Sandbox.Products', $config);
	}

	/**
	 * tearDown method
	 *
	 * @return void
	 */
	protected function tearDown(): void {
		unset($this->Products);

		parent::tearDown();
	}

	/**
	 * Test validationDefault method
	 *
	 * @uses \Sandbox\Model\Table\ProductsTable::validationDefault()
	 * @return void
	 */
	public function testSave(): void {
		$product = $this->Products->newEntity([
			'title' => 'x',
		]);
		$this->assertFalse($this->Products->save($product));

		$product = $this->Products->newEntity([
			'title' => 'x',
			'price' => '12.34',
			'stock' => 0,
		]);
		$result = $this->Products->save($product);
		$this->assertTrue((bool)$result);
	}

}
