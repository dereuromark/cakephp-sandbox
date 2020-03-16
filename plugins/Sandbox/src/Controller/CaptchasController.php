<?php

namespace Sandbox\Controller;

/**
 * Start page controller.
 *
 * @property \Sandbox\Model\Table\AnimalsTable $Animals
 */
class CaptchasController extends SandboxAppController {

	/**
	 * @var string
	 */
	protected $modelClass = 'Sandbox.Animals';

	/**
	 * @return void
	 */
	public function initialize(): void {
		parent::initialize();

		$this->viewBuilder()->setHelpers(['Captcha.Captcha']);
	}

	/**
	 * @return void
	 */
	public function index() {
	}

	/**
	 * @return \Cake\Http\Response|null|void
	 */
	public function math() {
		$animal = $this->Animals->newEmptyEntity();
		if ($this->request->is('post')) {
			$this->Animals->addBehavior('Captcha.Captcha');

			$animal = $this->Animals->patchEntity($animal, $this->request->getData());
			if ($this->Animals->save($animal)) {
				$this->Flash->success(__('The animal has been saved.'));

				// Remove again
				$this->Animals->delete($animal);
				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('The animal could not be saved. Please, try again.'));
		}
		$this->set(compact('animal'));
	}

}
