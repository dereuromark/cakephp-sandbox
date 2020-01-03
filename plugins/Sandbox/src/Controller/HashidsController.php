<?php

namespace Sandbox\Controller;

use Cake\Core\Configure;
use Cake\Event\Event;

/**
 * @property \Sandbox\Model\Table\HashidCountriesTable $HashidCountries
 */
class HashidsController extends SandboxAppController {

	/**
	 * @var string
	 */
	public $modelClass = 'Sandbox.HashidCountries';

	/**
	 * @param \Cake\Event\EventInterface $event
	 *
	 * @return void
	 */
	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);

		Configure::write('Hashid.debug', false);
		if ($this->request->getQuery('debug')) {
			Configure::write('Hashid.debug', true);
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
	 * Pagination example.
	 *
	 * When the request is ajax, just render the container,
	 * otherwise include the container ctp as element in the main ctp.
	 *
	 * The JS could probably be simplified or made more generic to be put
	 * in a central location and used for all paginations across the website.
	 *
	 * @return void
	 */
	public function pagination() {
		$this->loadModel('Sandbox.HashidCountries');

		$countries = $this->paginate('HashidCountries');

		$this->set(compact('countries'));
	}

	/**
	 * @param int|null $id
	 * @return void
	 */
	public function paginationView($id = null) {
		//$country = $this->HashidCountries->get($id);
		$country = $this->HashidCountries->find()->where(['id' => $id])->firstOrFail();

		$this->set(compact('country'));
	}

}
