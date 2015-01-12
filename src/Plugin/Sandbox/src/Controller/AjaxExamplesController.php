<?php
namespace Sandbox\Controller;

use Sandbox\Controller\SandboxAppController;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

class AjaxExamplesController extends SandboxAppController {

	public $components = array('Data.CountryProvinceHelper');

	public $helpers = array('Data.Data');

	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);

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
	 * AjaxExamplesController::simple()
	 *
	 * @return void
	 */
	public function simple() {
		if ($this->request->is(array('ajax'))) {
			// Lets create current datetime
			$now = date(FORMAT_DB_DATETIME);
			$this->set('result', array('now' => $now));
			$this->set('_serialize', array('result'));
		}
	}

	/**
	 * AjaxExamplesController::toggle()
	 *
	 * @return void
	 */
	public function toggle() {
		if ($this->request->is(array('ajax'))) {
			// Simulate a DB save via session
			$status = (bool)$this->request->query('status');
			$this->Session->write('AjaxToggle.status', $status);
			$this->set(compact('status'));

			// Manually render
			$View = $this->getView();
			$result = (string)$View->render();
			$View->set(compact('result'));

			// Since we already rendered the snippet, we need to reset the render state
			$View->hasRendered = false;
			$View->set('_serialize', array('result'));
			return;
		}

		// Read from DB (simulated)
		$status = (bool)$this->Session->read('AjaxToggle.status');

		$this->set(compact('status'));
	}

	/**
	 * AJAX Pagination example.
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
		$this->loadModel('Data.Countries');

		$this->Countries->recursive = 0;
		$countries = $this->paginate('Countries');
		$this->set(compact('countries'));

		if ($this->request->is('ajax')) {
			$this->render('pagination_container');
		}
	}

	/**
	 * Main AJAX example for chained dropdowns.
	 * If the first dropdown has been selected, it will trigger an
	 * AJAX call to pre-fill the next dropdown with the appropriate options.
	 *
	 * It should also prefill the previously selected choices on POST.
	 * That is what the component does here.
	 *
	 * @return void
	 */
	public function chained_dropdowns() {
		$this->Users = TableRegistry::get('Users');
		$user = $this->Users->newEntity();

		if ($this->request->is('post')) {

			/*
			$this->User->validate['country_province_id']['numeric'] = array(
				'rule' => 'numeric',
				'message' => 'Please select something'
			);
			*/
			$user = $this->Users->patchEntity($user, $this->request->data);
			//$result = $this->User->validates();
		}

		$this->CountryProvinceHelper->provideData(false, 'User');
	}

	/**
	 * My own convention was to suffix AJAX only actions with "_ajax".
	 *
	 * This method provides the AJAX data chained_dropdowns() needs.
	 *
	 * @return void
	 */
	public function country_provinces_ajax() {
		$this->request->allowMethod('ajax');
		$id = $this->request->query('id');
		if (!$id) {
			throw new NotFoundException();
		}

		$this->viewClass = 'Ajax.Ajax';

		$this->loadModel('Data.CountryProvinces');
		$countryProvinces = $this->CountryProvinces->getListByCountry($id);

		$this->set(compact('countryProvinces'));
	}

	/**
	 * AjaxExamplesController::redirecting()
	 *
	 * @return void
	 */
	public function redirecting() {

		if ($this->request->is('post')) {
			// Do sth like saving data
			return $this->redirect(array('action' => 'index'));
		}
	}

}

