<?php
namespace Sandbox\Controller;

use Cake\Event\Event;

/**
 */
class CacheExamplesController extends SandboxAppController {

	/**
	 * @return void
	 */
	public function initialize() {
		$this->loadComponent('Cache.Cache', [
			'actions' => [
				'minute' => MINUTE,
				'hour' => HOUR
			]
		]);
	}

	/**
	 * @return \Cake\Network\Response|null|void
	 */
	public function index() {
		$actions = $this->_getActions($this);

		$this->set(compact('actions'));
	}

	/**
	 * @return \Cake\Network\Response|null|void
	 */
	public function minute() {
		$this->Flash->info('Will be cached for a minute!');
	}

	/**
	 * @return \Cake\Network\Response|null|void
	 */
	public function hour() {
		$this->Flash->info('Will be cached for an hour!');

		$this->autoRender = false;
		$this->render('minute');
	}

}
