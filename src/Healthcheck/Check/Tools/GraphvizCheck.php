<?php
declare(strict_types=1);

namespace App\Healthcheck\Check\Tools;

use Setup\Healthcheck\Check\Check;

/**
 * Checks if GraphViz (dot command) is installed and working.
 *
 * GraphViz is required for generating state machine diagrams.
 */
class GraphvizCheck extends Check {

	/**
	 * @var string
	 */
	public const INFO = 'Checks if GraphViz (dot command) is installed for state machine diagrams.';

	/**
	 * @return void
	 */
	public function check(): void {
		$this->passed = false;

		// Check if dot command exists
		$output = [];
		$returnCode = 0;
		exec('which dot 2>/dev/null', $output, $returnCode);

		if ($returnCode !== 0 || !$output) {
			$this->failureMessage[] = 'GraphViz (dot) command not found.';
			$this->infoMessage[] = 'Install GraphViz: apt-get install graphviz';

			return;
		}

		// Verify dot actually works by getting version
		$versionOutput = [];
		exec('dot -V 2>&1', $versionOutput, $returnCode);

		if ($returnCode !== 0) {
			$this->failureMessage[] = 'GraphViz (dot) command failed to execute.';
			$this->infoMessage[] = 'Error: ' . implode(' ', $versionOutput);

			return;
		}

		$this->passed = true;
		$version = implode(' ', $versionOutput);
		$this->infoMessage[] = $version;
	}

}
