<?php

namespace Sandbox\Controller;

/**
 * @property \Sandbox\Model\Table\AnimalsTable $Animals
 */
class JsExamplesController extends SandboxAppController {

	/**
	 * @var string|bool
	 */
	public $modelClass = false;

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
		$this->loadModel('Sandbox.Animals');

		$animal = $this->Animals->newEmptyEntity();

		$this->Animals
			->getValidator()
			->date('created');

		if ($this->request->is('post')) {
			$animal = $this->Animals->patchEntity($animal, $this->request->getData(), ['fields' => ['created']]);

			if (!$animal->getErrors()) {
				$this->Flash->success('All good, valid date :)');
			}
		}

		$this->set(compact('animal'));
	}

}
