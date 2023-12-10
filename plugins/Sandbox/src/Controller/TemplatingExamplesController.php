<?php

namespace Sandbox\Controller;

use Cake\Core\Configure;
use Cake\Http\Exception\NotFoundException;
use Tools\View\Icon\IconCollection;

class TemplatingExamplesController extends SandboxAppController {

	/**
	 * @return void
	 */
	public function index() {
		$actions = $this->_getActions($this);

		$this->set(compact('actions'));
	}

	/**
	 * @return void
	 */
	public function icons() {
	}

	/**
	 * @return void
	 */
	public function iconSnippetHelper() {
	}

	/**
	 * @param string|null $name
	 *
	 * @return \Cake\Http\Response|null|void
	 */
	public function iconSets(?string $name = null) {
		if (!$name) {
			return $this->redirect(['action' => 'icons']);
		}

		Configure::write('Icon.checkExistence', false);

		$config = (array)Configure::read('Icon');
		if (!isset($config['sets'][$name])) {
			throw new NotFoundException('No such icon set');
		}

		$config['sets'] = [
			$name => $config['sets'][$name],
		];

		$icons = (new IconCollection($config))->names();
		$this->set(compact('icons', 'name'));
	}

}
