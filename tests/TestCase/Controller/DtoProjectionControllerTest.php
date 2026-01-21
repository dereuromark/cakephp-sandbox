<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use Shim\TestSuite\IntegrationTestCase;

/**
 * DtoProjectionControllerTest
 *
 * Tests the DTO projection examples using CakePHP 5.3's projectAs() feature.
 *
 * @uses \App\Controller\DtoProjectionController
 */
class DtoProjectionControllerTest extends IntegrationTestCase {

	/**
	 * @var list<string>
	 */
	protected array $fixtures = [
		'app.Users',
		'app.Roles',
	];

	/**
	 * Test index action - BelongsTo projection
	 *
	 * @return void
	 */
	public function testIndex(): void {
		$this->get(['controller' => 'DtoProjection', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();

		// Verify view variables exist (may be empty if no data)
		$this->assertNotNull($this->viewVariable('entities'));
		$this->assertNotNull($this->viewVariable('dtosSimple'));
		$this->assertNotNull($this->viewVariable('dtosPlugin'));
	}

	/**
	 * Test hasMany action - HasMany projection
	 *
	 * @return void
	 */
	public function testHasMany(): void {
		$this->get(['controller' => 'DtoProjection', 'action' => 'hasMany']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();

		$this->assertNotNull($this->viewVariable('entities'));
		$this->assertNotNull($this->viewVariable('dtos'));
	}

	/**
	 * Test belongsToMany action - BelongsToMany with _joinData
	 *
	 * This test may have empty results as demo data is created at runtime.
	 *
	 * @return void
	 */
	public function testBelongsToMany(): void {
		$this->get(['controller' => 'DtoProjection', 'action' => 'belongsToMany']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();

		$this->assertNotNull($this->viewVariable('entities'));
		$this->assertNotNull($this->viewVariable('dtos'));
	}

	/**
	 * Test matching action - matching() queries with _matchingData
	 *
	 * @return void
	 */
	public function testMatching(): void {
		$this->get(['controller' => 'DtoProjection', 'action' => 'matching']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();

		$this->assertNotNull($this->viewVariable('entities'));
		$this->assertNotNull($this->viewVariable('dtosWithout'));
		$this->assertNotNull($this->viewVariable('dtosWithArray'));
		$this->assertNotNull($this->viewVariable('dtosWithTyped'));
		$this->assertNotNull($this->viewVariable('rawArrays'));
	}

	/**
	 * Test benchmark action - Performance comparison
	 *
	 * @return void
	 */
	public function testBenchmark(): void {
		$this->get(['controller' => 'DtoProjection', 'action' => 'benchmark']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();

		$results = $this->viewVariable('results');
		$iterations = $this->viewVariable('iterations');

		$this->assertNotEmpty($results);
		$this->assertArrayHasKey('Entity', $results);
		$this->assertArrayHasKey('DtoMapper', $results);
		$this->assertArrayHasKey('cakephp-dto', $results);
		$this->assertArrayHasKey('Array', $results);
		$this->assertSame(100, $iterations);
	}

}
