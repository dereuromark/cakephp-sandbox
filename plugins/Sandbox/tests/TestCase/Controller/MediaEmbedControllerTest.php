<?php
declare(strict_types = 1);

namespace Sandbox\Test\TestCase\Controller;

use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use MediaEmbed\Http\HttpClientInterface;

/**
 * Sandbox\Controller\MediaEmbedController Test Case
 *
 * @uses \Sandbox\Controller\MediaEmbedController
 */
class MediaEmbedControllerTest extends TestCase {

	use IntegrationTestTrait;

	/**
	 * @return void
	 */
	protected function setUp(): void {
		parent::setUp();

		// oEmbed responses are cached, so one test's stubbed response must not leak into the next.
		Cache::clear();
	}

	/**
	 * @return void
	 */
	protected function tearDown(): void {
		Configure::delete('MediaEmbed.httpClient');

		parent::tearDown();
	}

	/**
	 * Test index method
	 *
	 * @return void
	 */
	public function testIndex(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'MediaEmbed', 'action' => 'index']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * Test index method with an oEmbed-only provider URL.
	 *
	 * Those providers fetch their markup at runtime, so the HTTP client is stubbed out.
	 *
	 * @return void
	 */
	public function testIndexOEmbedOnly(): void {
		$response = json_encode([
			'type' => 'rich',
			'version' => '1.0',
			'author_name' => 'Bluesky (bsky.app)',
			'provider_name' => 'Bluesky Social',
			'width' => 600,
			'html' => '<blockquote class="bluesky-embed">Test post</blockquote>',
		], JSON_THROW_ON_ERROR);
		Configure::write('MediaEmbed.httpClient', $this->httpClient($response));

		$url = 'https://bsky.app/profile/bsky.app/post/3mbhel6ij7s2y';
		$this->get(['plugin' => 'Sandbox', 'controller' => 'MediaEmbed', 'action' => 'index', '?' => ['url' => $url]]);

		$this->assertResponseCode(200);
		$this->assertResponseContains('oEmbed-only');
		$this->assertResponseContains('Bluesky Social');
		$this->assertResponseContains('bluesky-embed');
	}

	/**
	 * Test index method when the provider cannot be reached.
	 *
	 * @return void
	 */
	public function testIndexOEmbedFailure(): void {
		Configure::write('MediaEmbed.httpClient', $this->httpClient(null));

		$url = 'https://bsky.app/profile/bsky.app/post/3mbhel6ij7s2y';
		$this->get(['plugin' => 'Sandbox', 'controller' => 'MediaEmbed', 'action' => 'index', '?' => ['url' => $url]]);

		$this->assertResponseCode(200);
		$this->assertResponseContains('No oEmbed response');
	}

	/**
	 * Test oembed method
	 *
	 * @return void
	 */
	public function testOembed(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'MediaEmbed', 'action' => 'oembed']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
		$this->assertResponseContains('EmbedCodeUnavailableException');
	}

	/**
	 * Test bbcode method
	 *
	 * @return void
	 */
	public function testBbcode(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'MediaEmbed', 'action' => 'bbcode']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * Test hosts method
	 *
	 * @return void
	 */
	public function testHosts(): void {
		$this->get(['plugin' => 'Sandbox', 'controller' => 'MediaEmbed', 'action' => 'hosts']);

		$this->assertResponseCode(200);
		$this->assertNoRedirect();
	}

	/**
	 * An HTTP client that answers every request with the given body, without network access.
	 *
	 * @param string|null $body
	 * @return \MediaEmbed\Http\HttpClientInterface
	 */
	protected function httpClient(?string $body): HttpClientInterface {
		return new class ($body) implements HttpClientInterface {

			/**
			 * @var string|null
			 */
			protected ?string $body;

			/**
			 * @param string|null $body
			 */
			public function __construct(?string $body) {
				$this->body = $body;
			}

			/**
			 * @param string $url
			 * @param array<string, mixed> $options
			 * @return string|null
			 */
			public function get(string $url, array $options = []): ?string {
				return $this->body;
			}

		};
	}

}
