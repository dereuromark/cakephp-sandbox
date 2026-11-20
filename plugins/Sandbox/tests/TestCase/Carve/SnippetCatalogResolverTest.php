<?php
declare(strict_types=1);

namespace Sandbox\Test\TestCase\Carve;

use Cake\Core\Configure;
use Cake\TestSuite\TestCase;
use Sandbox\Carve\SnippetCatalogResolver;

/**
 * Sandbox\Carve\SnippetCatalogResolver Test Case
 */
class SnippetCatalogResolverTest extends TestCase {

	/**
	 * @return void
	 */
	public function testRejectsUnsafePaths(): void {
		/** @var array<string, array{title: string, source: string}> $snippets */
		$snippets = Configure::read('CarveSnippets', []);
		$resolver = new SnippetCatalogResolver($snippets);
		foreach ([
			"library/file\0.crv",
			'library\\intro.crv',
			'library/http:example.crv',
			'library/../../config/app.php',
		] as $path) {
			$result = $resolver->resolve(['path' => $path, 'options' => [], 'from' => 'library/chapter.crv', 'budget' => 4096]);
			$this->assertSame(['error' => 'outside_root'], $result, $path);
		}
	}

	/**
	 * @return void
	 */
	public function testResolvesRelativeToIncludingSnippet(): void {
		/** @var array<string, array{title: string, source: string}> $snippets */
		$snippets = Configure::read('CarveSnippets', []);
		$resolver = new SnippetCatalogResolver($snippets);

		$result = $resolver->resolve(['path' => 'sign-off.crv', 'options' => [], 'from' => 'library/chapter.crv', 'budget' => 4096]);
		$this->assertSame('library/sign-off.crv', $result['id'] ?? null);
		$this->assertSame($snippets['library/sign-off.crv']['source'], $result['text'] ?? null);

		$missing = $resolver->resolve(['path' => 'library/none.crv', 'options' => [], 'budget' => 4096]);
		$this->assertSame(['error' => 'not_found'], $missing);
	}

}
