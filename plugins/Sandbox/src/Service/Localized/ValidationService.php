<?php

namespace Sandbox\Service\Localized;

use DirectoryIterator;
use RuntimeException;

class ValidationService {

	/**
	 * @return array<string, array<string>>
	 */
	public function getAvailable(): array {
		$path = ROOT . DS . 'vendor/cakephp/localized/src/Validation/';
		$iterator = new DirectoryIterator($path);

		$available = [];

		/** @var \DirectoryIterator $file */
		foreach ($iterator as $file) {
			if (!$file->isFile() || $file->isDot()) {
				continue;
			}

			$filename = $file->getBasename('.php');
			preg_match('/^([A-Z][a-z])Validation$/', $filename, $matches);
			if (!$matches) {
				continue;
			}

			$available[(string)$matches[1]] = $this->extractDetails((string)$file->getRealPath());
		}

		ksort($available);

		return $available;
	}

	/**
	 * @param string $path
	 * @throws \RuntimeException
	 * @return array<string>
	 */
	protected function extractDetails(string $path): array {
		$content = file_get_contents($path);
		if ($content === false) {
			throw new RuntimeException('Cannot open file ' . $path);
		}

		preg_match_all('/public static function (\w+)\(/', $content, $matches);
		if (!$matches) {
			return [];
		}

		$methods = $matches[1];
		sort($methods);

		return $methods;
	}

}
