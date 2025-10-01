<?php

namespace Sandbox\Controller;

use Cake\Event\EventInterface;
use Cake\View\JsonView;

/**
 * @property \Sandbox\Model\Table\AnimalsTable $Animals
 */
class JqueryExamplesController extends SandboxAppController {

	/**
	 * @var array<string>
	 */
	protected $jqueryPlugins = ['media'];

	/**
	 * @return string[]
	 */
	public function viewClasses(): array {
		return [JsonView::class];
	}

	/**
	 * @param \Cake\Event\EventInterface $event
	 * @return void
	 */
	public function beforeRender(EventInterface $event) {
		$this->set('jquery_plugins', $this->jqueryPlugins);

		parent::beforeRender($event);
	}

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
	public function autopreview() {
	}

	/**
	 * @return void
	 */
	public function maxlength() {
	}

	/**
	 * Example of an autocomplete field using jQueryUI autocomplete with JSON
	 * and AJAX
	 *
	 * @return void
	 */
	public function autocomplete() {
		if ($this->request->is(['ajax'])) {
			$Animals = $this->fetchTable('Sandbox.Animals');
			$items = $Animals->find('list', conditions: [
				'name LIKE' => '%' . (string)$this->request->getQuery('term') . '%',
			]);

			$this->set('items', $items);
			$serialize = 'items';
			$this->viewBuilder()->setOptions(compact('serialize'));
		}
	}

}
