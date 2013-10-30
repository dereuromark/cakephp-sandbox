<?php

App::uses('AppShell', 'Console/Command');
//App::uses('Folder', 'Utility');

class FontIconShell extends AppShell {

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

		$diffLeft = array();
		foreach ($matchesRight as $m) {
			if (!in_array($m, $matchesLeft)) {
				continue;
			}
			$diffLeft[] = $m;
		}
		//$diffRight =
		//echo returns($diffLeft);
		$this->out('Common icons (overlapping classes):');
		echo returns($diffLeft);
	}

	/**
	 * @return array
	 */
	protected function _foldersMabo() {
		$folder = Configure::read('Tradeplace.maboImportFolder');
		$Folder = new Folder($folder);
		$content = $Folder->read(true, true);
		return $content[0];
	}

	public function getOptionParser() {
		$subcommandParser = array(
			'options' => array(
				'dry-run' => array(
					'short' => 'd',
					'help' => __d('cake_console', 'Dry run.'),
					'boolean' => true
				),
			)
		);

		return parent::getOptionParser()
			->description(__d('cake_console', "A shell to work with font icons via CSS and custom fonts."))
			->addSubcommand('compare', array(
				'help' => __d('cake_console', 'Compare two scripts.'),
				'parser' => $subcommandParser
			))
			->addArgument('left', array('required' => true))
			->addArgument('right', array('required' => true));
	}

}
