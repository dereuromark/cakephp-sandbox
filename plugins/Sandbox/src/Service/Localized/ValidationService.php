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

			$available[strtoupper($matches[1])] = $this->extractDetails((string)$file->getRealPath());
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
		if (empty($matches[1])) {
			return [];
		}

		$methods = $matches[1];
		sort($methods);

		return $methods;
	}

	/**
	 * @param string|null $method
	 *
	 * @return array<string, string>
	 */
	public function getCodes(?string $method): array {
		if (!$method) {
			return [];
		}

		$available = $this->getAvailable();
		$codes = [];
		foreach ($available as $code => $list) {
			if (in_array($method, $list, true)) {
				$codes[$code] = $code;
			}
		}

		return $codes;
	}

	/**
	 * Get methods sorted by most usage DESC.
	 *
	 * @return array<string>
	 */
	public function getMethods(): array {
		$available = $this->getAvailable();

		$methods = [];
		foreach ($available as $list) {
			foreach ($list as $method) {
				if (!isset($methods[$method])) {
					$methods[$method] = 0;
				}
				$methods[$method] += 1;
			}
		}

		arsort($methods);

		return array_keys($methods);
	}

}
