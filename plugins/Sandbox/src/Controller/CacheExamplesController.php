<?php

namespace Sandbox\Controller;

use Cake\View\JsonView;

/**
 * @property \Cache\Controller\Component\CacheComponent $Cache
 */
class CacheExamplesController extends SandboxAppController {

	/**
	 * @return string[]
	 */
	public function viewClasses(): array {
		return [JsonView::class];
	}

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
	 * @return \Cake\Http\Response|null|void
	 */
	public function index() {
		$actions = $this->_getActions($this);
		$actions = array_diff($actions, ['someJson']);

		$this->set(compact('actions'));
	}

	/**
	 * @return \Cake\Http\Response|null|void
	 */
	public function minute() {
		$this->Flash->info('Will be cached for a minute!');
	}

	/**
	 * @return \Cake\Http\Response|null|void
	 */
	public function hour() {
		$this->Flash->info('Will be cached for an hour!');

		$this->autoRender = false;

		return $this->render('minute');
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
		$serialize = 'something';
		$this->viewBuilder()->setOptions(compact('serialize'));
	}

}
