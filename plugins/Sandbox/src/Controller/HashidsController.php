<?php
namespace Sandbox\Controller;

use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\ORM\TableRegistry;

class HashidsController extends SandboxAppController {

	public $modelClass = 'Sandbox.HashidCountries';

	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);

		Configure::write('Hashid.debug', false);
		if ($this->request->query('debug')) {
			Configure::write('Hashid.debug', true);
		}

		$this->Auth->allow();
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

	public function paginationView($id = null) {
		//$country = $this->HashidCountries->get($id);
		$country = $this->HashidCountries->find()->where(['id' => $id])->firstOrFail();

		$this->set(compact('country'));
	}

}
