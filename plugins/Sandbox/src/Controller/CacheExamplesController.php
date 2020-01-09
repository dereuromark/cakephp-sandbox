<?php

namespace Sandbox\Controller;

/**
 * @property \Cache\Controller\Component\CacheComponent $Cache
 */
class CacheExamplesController extends SandboxAppController {

	/**
	 * @var string|false
	 */
	public $modelClass = false;

	/**
	 * @return void
	 */
	public function initialize(): void {
		parent::initialize();

		$this->loadComponent('Cache.Cache', [
			'actions' => [
				'minute' => MINUTE,
				'hour' => HOUR,
				'someJson' => MINUTE,
			],
			'force' => true, // To showcase also in debug mode locally
		]);
	}

	/**
	 * @return \Cake\Http\Response|null
	 */
	public function index() {
		$actions = $this->_getActions($this);
		$actions = array_diff($actions, ['someJson']);

		$this->set(compact('actions'));
	}

	/**
	 * @return \Cake\Http\Response|null
	 */
	public function minute() {
		$this->Flash->info('Will be cached for a minute!');
	}

	/**
	 * @return \Cake\Http\Response|null
	 */
	public function hour() {
		$this->Flash->info('Will be cached for an hour!');

		$this->autoRender = false;
		$this->render('minute');
	}

	/**
	 * @return void
	 */
	public function someJson() {
		$something = [
			'json' => 'This data is not changed for 1 min',
			'generated' => date(FORMAT_DB_DATETIME),
		];

		$this->set(compact('something'));
		$this->set('_serialize', ['something']);
	}

}
