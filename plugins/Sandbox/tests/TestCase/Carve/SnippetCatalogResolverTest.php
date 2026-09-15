<?php
declare(strict_types=1);

namespace Sandbox\Test\TestCase\Carve;

use Cake\Core\Configure;
use Cake\TestSuite\TestCase;
use MarkupCarve\Carve\Transform\IncludeContext;
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
		$context = new IncludeContext('library/chapter.crv');

		foreach ([
			"library/file\0.crv",
			'library\\intro.crv',
			'library/http:example.crv',
			'library/../../config/app.php',
		] as $path) {
			$this->assertNull($resolver->resolve($path, $context), $path);
		}
	}

}
