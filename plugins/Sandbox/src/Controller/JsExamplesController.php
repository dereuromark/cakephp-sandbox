<?php

namespace Sandbox\Controller;

/**
 * @property \Sandbox\Model\Table\AnimalsTable $Animals
 */
class JsExamplesController extends SandboxAppController {

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
	public function datepicker() {
		$Animals = $this->fetchTable('Sandbox.Animals');

		$animal = $Animals->newEmptyEntity();

		$Animals
			->getValidator()
			->date('created');

		if ($this->request->is('post')) {
			$animal = $Animals->patchEntity($animal, $this->request->getData(), ['fields' => ['created']]);

			if (!$animal->getErrors()) {
				$this->Flash->success('All good, valid date :)');
			}
		}

		$this->set(compact('animal'));
	}

}
