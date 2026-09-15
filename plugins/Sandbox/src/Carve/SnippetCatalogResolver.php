<?php
declare(strict_types=1);

namespace Sandbox\Carve;

use MarkupCarve\Carve\Transform\IncludeContext;
use MarkupCarve\Carve\Transform\IncludeResolverInterface;
use MarkupCarve\Carve\Transform\ResolvedInclude;

/**
 * Resolves only the public, read-only `library/` namespace from a source map.
 */
class SnippetCatalogResolver implements IncludeResolverInterface {

	/**
	 * @param array<string, array{title: string, source: string}> $snippets
	 */
	public function __construct(protected array $snippets) {
	}

	public function resolve(string $path, IncludeContext $context): ?ResolvedInclude {
		$canonical = $this->canonicalPath($path, $context->getIncludingPath());
		if ($canonical === null) {
			return null;
		}

		$snippet = $this->snippets[$canonical] ?? null;
		if ($snippet === null) {
			return null;
		}

		return new ResolvedInclude($snippet['source'], $canonical);
	}

	protected function canonicalPath(string $path, ?string $includingPath): ?string {
		if ($path === '' || str_contains($path, "\0") || str_contains($path, '\\')) {
			return null;
		}

		if (str_starts_with($path, 'library/')) {
			$candidate = $path;
		} elseif ($includingPath !== null && str_starts_with($includingPath, 'library/')) {
			$candidate = dirname($includingPath) . '/' . $path;
		} else {
			return null;
		}

		$segments = [];
		foreach (explode('/', $candidate) as $segment) {
			if ($segment === '' || $segment === '.') {
				continue;
			}

			if ($segment === '..') {
				if (count($segments) <= 1) {
					return null;
				}
				array_pop($segments);

				continue;
			}
			$segments[] = $segment;
		}

		$canonical = implode('/', $segments);
		if (!str_starts_with($canonical, 'library/') || str_contains($canonical, ':')) {
			return null;
		}

		return $canonical;
	}

}
