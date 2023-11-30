<?php

namespace Sandbox\Controller;

use Cake\Database\TypeFactory;
use PhpCollective\DecimalObject\Decimal;
use Throwable;

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

			return $this->redirect([]);
		}

		if ($this->request->is(['post', 'put'])) {
			$record = $this->fetchTable('Sandbox.SandboxProfiles')->patchEntity($record, $this->request->getData());
			$this->Flash->info('The record has been patched/updated, see the outputted values of those fields below');
		}

		$this->set(compact('record'));
	}

	/**
	 * @return \Cake\Http\Response|null|void
	 */
	public function validation(?string $locale = null) {
		if ($locale && preg_match('/^[a-z]{2}_[A-Z]{2}$/', $locale)) {
			$this->Flash->info('Using locale ' . h($locale));

			ini_set('intl.default_locale', $locale);
			TypeFactory::build('decimal')->useLocaleParser();
		}

		$record = $this->fetchTable('Sandbox.SandboxProfiles')->newEmptyEntity();
		$this->fetchTable('Sandbox.SandboxProfiles')->getValidator()->decimal('balance', 2);

		$result = null;
		if ($this->request->is(['post', 'put'])) {
			$runtimeErrors = false;
			try {
				$record = $this->fetchTable('Sandbox.SandboxProfiles')->patchEntity($record, $this->request->getData());
			} catch (\Exception $e) {
				$runtimeErrors = true;
				$this->Flash->error('Hard fail: ' . $e->getMessage());
			}
			if (!$runtimeErrors) {
				if ($record->getErrors()) {
					$this->Flash->error('Validation error.');
				} else {
					$this->Flash->success('All good :)');
				}
			}

			$result = $record->get('balance');
		}

		$this->set(compact('record', 'result'));
	}

	/**
	 * @return \Cake\Http\Response|null|void
	 */
	public function api() {
		$operations = [
			'add',
			'subtract',
			'multiply',
			'divide',
			'equals',
			'greaterThan',
			'lessThan',
			'greaterThanOrEquals',
			'lessThanOrEquals',
			'pow',
			'mod',
		];

		$result = null;
		if ($this->request->is(['post', 'put'])) {
			$one = $this->request->getData('one');
			$two = $this->request->getData('two');
			$operationKey = $this->request->getData('operation');
			if (!isset($operations[$operationKey])) {
				$this->Flash->error('This operation does not exist');

				return $this->redirect([]);
			}

			$operation = $operations[$operationKey];
			try {
				$one = Decimal::create($one);
				$two = Decimal::create($two);

				if ($operation === 'divide') {
					$result = $one->divide($two, max($one->scale(), $two->scale()));
				} else {
					$result = $one->$operation($two);
				}

			} catch (Throwable $exception) {
				$this->Flash->error($exception->getMessage());
			}
		}

		$this->set(compact('operations', 'result'));
	}

}
