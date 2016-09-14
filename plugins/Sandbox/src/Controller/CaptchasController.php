<?php
namespace Sandbox\Controller;

use Cake\Event\Event;

/**
 * Start page controller.
 */
class CaptchasController extends SandboxAppController {

	public $modelClass = 'Sandbox.Animals';

	public $helpers = ['Captcha.Captcha'];

	/**
	 * @return void
	 */
	public function index() {

	}

	/**
	 * @return \Cake\Network\Response|null
	 */
	public function math() {
		$animal = $this->Animals->newEntity();
		if ($this->request->is('post')) {
			$animal = $this->Animals->patchEntity($animal, $this->request->data);
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
