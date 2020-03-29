<?php

namespace Sandbox\Controller;

/**
 * @property \App\Model\Table\UsersTable $Users
 */
class FlashExamplesController extends SandboxAppController {

	/**
	 * List of all examples.
	 *
	 * @return void
	 */
	public function index() {
	}

	/**
	 * @return void
	 */
	public function messages() {
		// We use here transient ones for demo, you could also use normal ones
		$this->Flash->transientWarning('This is a warning...');
		$this->Flash->transientError('An error occurred somewhere');
		$this->Flash->transientWarning('This is a second very interesting warning');
		$this->Flash->transientSuccess('Good Job :) You did it');
		$this->Flash->transientInfo('I am some info message for you');
	}

	/**
	 * @return void
	 */
	public function messageGroups() {
		// We use here view level ones for demo, those are always transient
	}

	/**
	 * @return void
	 */
	public function ajax() {
	}
}
