<?php
namespace Sandbox\Shell;

use Cake\Console\Shell;

/**
 * Class FontIconShell
 *
 * @deprecated
 */
class FontIconShell extends Shell {

	public function initialize() {
		parent::initialize();
	}

	/**
	 * Compare two sets
	 *
	 * @return void
	 */
	public function compare() {
		if (count($this->args) !== 2) {
			return $this->error('left and right are required.');
		}
		$left = realpath($this->args[0]);
		$right = realpath($this->args[1]);
		if (!$left || !$right) {
			return $this->error('left or right is invalid.');
		}

		$content = file_get_contents($left);
		preg_match_all('/\.(icon-[a-z0-9-]+)\s*\:/', $content, $matches);
		if (!$matches) {
			return $this->error('invalid left');
		}
		$matchesLeft = $matches[1];

		$content = file_get_contents($right);
		preg_match_all('/\.(icon-[a-z0-9-]+)\s*\:/', $content, $matches);
		if (!$matches) {
			return $this->error('invalid right');
		}
		$matchesRight = $matches[1];

		$diffLeft = [];
		foreach ($matchesRight as $m) {
			if (!in_array($m, $matchesLeft)) {
				continue;
			}
			$diffLeft[] = $m;
		}

		$this->out('Common icons (overlapping classes):');
		debug($diffLeft);
	}

	public function getOptionParser() {
		$subcommandParser = [
			'options' => [
				'dry-run' => [
					'short' => 'd',
					'help' => 'Dry run.',
					'boolean' => true
				],
			]
		];

		return parent::getOptionParser()
			->description("A shell to work with font icons via CSS and custom fonts.")
			->addSubcommand('compare', [
				'help' => 'Compare two scripts.',
				'parser' => $subcommandParser
			])
			->addArgument('left', ['required' => true])
			->addArgument('right', ['required' => true]);
	}

}
