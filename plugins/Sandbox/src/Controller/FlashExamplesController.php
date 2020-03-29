<?php

namespace Sandbox\Controller;

use Tools\Utility\Text;

/**
 * @property \Ajax\Controller\Component\AjaxComponent $Ajax
 */
class FlashExamplesController extends SandboxAppController {

	/**
	 * @return void
	 */
	public function initialize(): void {
		parent::initialize();

		if (in_array($this->request->getParam('action'), ['ajaxPlugin'], true)) {
			$this->loadComponent('Ajax.Ajax');
		}
	}

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
	 * @return \Cake\Http\Response|null|void
	 */
	public function ajax() {
		// We simulate some action
		if ($this->request->is('post')) {
			$now = date(FORMAT_DB_DATETIME);
			$this->Flash->transientSuccess('All right, we did it now (' . $now . ')!');

			$this->set(compact('now'));
		}
	}

	/**
	 * Using Ajax plugin to be able to use redirects and dont re-render the page.
	 *
	 * @return \Cake\Http\Response|null|void
	 */
	public function ajaxPlugin() {
		// We simulate some action
		if ($this->request->is('post')) {
			$now = date(FORMAT_DB_DATETIME);
			$this->Flash->transientSuccess('All right, we did it now (' . $now . ')!');
			$now = Text::slug($now);

			// We can only use returns here if we use Ajax plugin to prevent the redirect.
			return $this->redirect(['action' => 'ajax', '?' => ['now' => $now]]);
		}
	}
}
