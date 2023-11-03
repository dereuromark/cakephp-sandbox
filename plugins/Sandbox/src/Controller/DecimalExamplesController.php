<?php

namespace Sandbox\Controller;

class DecimalExamplesController extends SandboxAppController {

	/**
	 * @return void
	 */
	public function index() {
	}

	/**
	 * @return \Cake\Http\Response|null|void
	 */
	public function forms() {
		$record = $this->fetchTable('Sandbox.SandboxProfiles')->find()->first();
		if (!$record) {
			$record = $this->fetchTable('Sandbox.SandboxProfiles')->newEntity([
				'username' => 'Demo',
			]);
			$this->fetchTable('Sandbox.SandboxProfiles')->saveOrFail($record);
		}

		if ($this->request->is(['post', 'put'])) {
			$record = $this->fetchTable('Sandbox.SandboxProfiles')->patchEntity($record, $this->request->getData());
			$this->Flash->info('The record has been patched/updated, see the outputted values of those fields below');
		}

		$this->set(compact('record'));
	}

}
