<?php

namespace Sandbox\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * Sandbox\Controller\CakeExamplesController Test Case
 *
 * @uses \Sandbox\Controller\CakeExamplesController
 */
class CakeExamplesControllerTest extends TestCase {

	use IntegrationTestTrait;

	/**
	 * Fixtures
	 *
	 * @var array
	 */
	protected array $fixtures = [
		'plugin.Sandbox.SandboxAnimals',
		'plugin.Sandbox.SandboxUsers',
		'plugin.Sandbox.SandboxPosts',
		'plugin.Sandbox.SandboxProducts',
	];

	/**
	 * Test index method
	 *
	 * @return void
	 */
	public function testIndex(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'CakeExamples', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * Test queryStrings method
	 *
	 * @return void
	 */
	public function testQueryStrings(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'CakeExamples', 'action' => 'queryStrings']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * Test merge method
	 *
	 * @return void
	 */
	public function testMerge(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'CakeExamples', 'action' => 'merge']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * Test i18n method
	 *
	 * @return void
	 */
	public function testI18n(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'CakeExamples', 'action' => 'i18n']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * Test validation method
	 *
	 * @return void
	 */
	public function testValidation(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'CakeExamples', 'action' => 'validation']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * Test validation method
	 *
	 * @return void
	 */
	public function testValidationPostInvalid(): void {
		$this->post(['plugin' => 'Sandbox', 'controller' => 'CakeExamples', 'action' => 'validation']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * Test validation method
	 *
	 * @return void
	 */
	public function testValidationPostValid(): void {
		$data = [
			'name' => 'Mouse',
			'confirm' => true,
		];
		$this->post(['plugin' => 'Sandbox', 'controller' => 'CakeExamples', 'action' => 'validation'], $data);

		$this->assertResponseCode(302);
		$this->assertRedirect();
	}

	/**
	 * Test enums method
	 *
	 * @return void
	 */
	public function testEnums(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'CakeExamples', 'action' => 'enums']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * Test enumValidation method
	 *
	 * @return void
	 */
	public function testEnumValidation(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'CakeExamples', 'action' => 'enumValidation']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * Test paginateNonDatabase method
	 *
	 * @return void
	 */
	public function testPaginateNonDatabase(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'CakeExamples', 'action' => 'paginateNonDatabase']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * Test translateBehavior method
	 *
	 * @return void
	 */
	public function testTranslateBehavior(): void {
		$this->disableErrorHandlerMiddleware();

		$this->get(['plugin' => 'Sandbox', 'controller' => 'CakeExamples', 'action' => 'translateBehavior']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * Test translateBehavior method with locale parameter
	 *
	 * @return void
	 */
	public function testTranslateBehaviorWithLocale(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'CakeExamples', 'action' => 'translateBehavior', '?' => ['locale' => 'de']]);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * Test paginateCombinedSort method
	 * Tests basic pagination without sorting
	 *
	 * @return void
	 */
	public function testPaginateCombinedSort(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'CakeExamples', 'action' => 'paginateCombinedSort']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
		$this->assertResponseContains('Combined Sort Pagination');
	}

	/**
	 * Test paginateCombinedSort with single column ascending sort
	 * CakePHP 5.3 feature: sort with direction included in key
	 *
	 * @return void
	 */
	public function testPaginateCombinedSortTitleAsc(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'CakeExamples', 'action' => 'paginateCombinedSort', '?' => ['sort' => 'title-asc']]);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * Test paginateCombinedSort with single column descending sort
	 * CakePHP 5.3 feature: sort with direction included in key
	 *
	 * @return void
	 */
	public function testPaginateCombinedSortCreatedDesc(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'CakeExamples', 'action' => 'paginateCombinedSort', '?' => ['sort' => 'created-desc']]);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * Test paginateCombinedSort with custom multi-column sort
	 * CakePHP 5.3 feature: Custom sort key with multiple fields
	 *
	 * @return void
	 */
	public function testPaginateCombinedSortMultiColumn(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'CakeExamples', 'action' => 'paginateCombinedSort', '?' => ['sort' => 'expensive-desc']]);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * Test rateLimiter page loads and applies rate limit headers
	 * CakePHP 5.3 feature: RateLimitMiddleware
	 *
	 * @return void
	 */
	public function testRateLimiterPageLoads(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'CakeExamples', 'action' => 'rateLimiter']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
		$this->assertResponseContains('Rate Limit Middleware');

		// Verify rate limit headers are present
		$this->assertHeader('X-RateLimit-Limit', '5');
		// Check that X-RateLimit-Remaining header exists (value depends on previous test state)
		$headers = $this->_response->getHeaders();
		$this->assertArrayHasKey('X-RateLimit-Remaining', $headers, 'X-RateLimit-Remaining header should be present');
	}

	/**
	 * Test that rate limiter is NOT applied to other actions
	 *
	 * @return void
	 */
	public function testRateLimiterOnlyAppliesRateLimiterAction(): void {
		// Make multiple requests to a different action
		// This verifies rate limiting is scoped to specific action only
		for ($i = 1; $i <= 5; $i++) {
			$this->get(['plugin' => 'Sandbox', 'controller' => 'CakeExamples', 'action' => 'index']);
			$this->assertResponseCode(200, "Request $i should succeed - rate limiter should not apply");
		}
	}

}
