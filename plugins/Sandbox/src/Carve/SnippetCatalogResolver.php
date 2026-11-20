<?php
declare(strict_types=1);

namespace Sandbox\Carve;

use MarkupCarve\Carve\Include\IncludeResolver;

/**
 * Resolves only the public, read-only `library/` namespace from a source map.
 */
class SnippetCatalogResolver implements IncludeResolver {

	/**
	 * @param array<string, array{title: string, source: string}> $snippets
	 */
	public function __construct(protected array $snippets) {
	}

	/**
	 * @param array{path: string, options: array<mixed>, section?: mixed, from?: string, budget: int} $request
	 * @return array{text: string, id: string}|array{error: string, id?: string}
	 */
	public function resolve(array $request): array {
		$canonical = $this->canonicalPath($request['path'], $request['from'] ?? null);
		if ($canonical === null) {
			return ['error' => 'outside_root'];
		}

		$snippet = $this->snippets[$canonical] ?? null;
		if ($snippet === null) {
			return ['error' => 'not_found'];
		}
		if (strlen($snippet['source']) > $request['budget']) {
			return ['error' => 'size_exceeded', 'id' => $canonical];
		}

		return ['text' => $snippet['source'], 'id' => $canonical];
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
