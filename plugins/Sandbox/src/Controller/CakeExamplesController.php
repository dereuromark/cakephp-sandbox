<?php

namespace Sandbox\Controller;

use Cake\Http\Exception\NotFoundException;
use Cake\I18n\I18n;
use Cake\Utility\Hash;

/**
 * @property \Sandbox\Model\Table\AnimalsTable $Animals
 */
class CakeExamplesController extends SandboxAppController {

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
	public function queryStrings() {
	}

	/**
	 * @return void
	 */
	public function merge() {
		$array = [
			'root' => [
				'deep1' => ['deeper1a' => 'value1a', 'deeper2b' => 'value2b'],
				'deep2' => ['deeper1', 'deeper2'],
				'deep3' => 'stringX',
			],
		];
		$mergeArray = [
			'root' => [
				'deep1' => ['deeper1a' => 'value1a', 'deeper3b' => 'value3b'],
				'deep2' => ['deeper1', 'deeper3'],
				'deep3' => 'stringY',
			],
		];

		$result = null;
		$type = $this->request->getQuery('type');
		$result = null;
		if ($type) {
			switch ($type) {
				case 'hash':
					$result = Hash::merge($array, $mergeArray);

					break;
				case 'array_merge':
					$result = array_merge($array, $mergeArray);

					break;
				case 'array_merge_recursive':
					$result = array_merge_recursive($array, $mergeArray);

					break;
				default:
					throw new NotFoundException('Invalid merge type');
			}
		}

		$this->set(compact('array', 'mergeArray', 'result'));
	}

	/**
	 * @return \Cake\Http\Response|null|void
	 */
	public function i18n() {
		// Make sure we have defaults set to I18n if language has been switched previously
		$lang = $this->request->getSession()->read('Config.language');
		if ($lang) {
			I18n::setLocale($lang);
		} else {
			$this->request->getSession()->write('Config.language', 'en');
		}

		// Language switcher
		if ($this->request->is('post')) {
			$lang = (string)$this->request->getQuery('lang');
			$this->request->getSession()->write('Config.language', $lang);
			I18n::setLocale($lang);
			$lang = locale_get_display_name($lang) . ' [' . strtoupper($lang) . ']';
			$this->Flash->success(__('Language switched to {0}.', h($lang)), ['escape' => false]);

			return $this->redirect(['action' => 'i18n']);
		}
	}

	/**
	 * Test validation on marshal and rules on save.
	 *
	 * @return \Cake\Http\Response|null|void
	 */
	public function validation() {
		$this->loadModel('Sandbox.Animals');

		$animal = $this->Animals->newEmptyEntity();

		if ($this->request->is('post')) {
			$animal = $this->Animals->patchEntity($animal, $this->request->getData());

			// Simulate $Animals->save($animal) call as we dont't want to really save here
			if (!$animal->getErrors() & $this->Animals->checkRules($animal)) {
				$this->Flash->success('Yeah, entry would have been saved.');

				return $this->redirect(['action' => 'validation']);
			}

			$this->Flash->error('Please correct your form content.');
		}

		$this->set(compact('animal'));
	}

}
