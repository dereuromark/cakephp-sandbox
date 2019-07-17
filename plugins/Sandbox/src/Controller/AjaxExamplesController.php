<?php
namespace Sandbox\Controller;

use Cake\Http\Exception\NotFoundException;

/**
 * @property \Data\Controller\Component\CountryStateHelperComponent $CountryStateHelper
 * @property \Data\Model\Table\CountriesTable $Countries
 * @property \Data\Model\Table\StatesTable $States
 * @property \App\Model\Table\UsersTable $Users
 */
class AjaxExamplesController extends SandboxAppController {

	/**
	 * @var string|bool
	 */
	public $modelClass = false;

	/**
	 * @var array
	 */
	public $components = ['Data.CountryStateHelper'];

	/**
	 * @var array
	 */
	public $helpers = ['Data.Data'];

	/**
	 * @return void
	 */
	public function initialize() {
		if (in_array($this->request->getParam('action'), ['redirectingPrevented', 'form', 'toggle'])) {
			$this->components['Ajax.Ajax'] = [];
		}
		parent::initialize();
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
		if ($this->request->is(['ajax'])) {
			// Lets create current datetime
			$now = date(FORMAT_DB_DATETIME);
			$this->set('result', ['now' => $now]);
			$this->set('_serialize', ['result']);
		}
	}

	/**
	 * AjaxExamplesController::toggle()
	 *
	 * @return \Cake\Http\Response|null
	 */
	public function toggle() {
		if ($this->request->is(['post'])) {
			// Simulate a DB save via session
			$status = (bool)$this->request->getQuery('status');
			$this->request->session()->write('AjaxToggle.status', $status);
		}

		// Read from DB (simulated)
		$status = (bool)$this->request->session()->read('AjaxToggle.status');

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

		$countries = $this->paginate('Countries');
		$this->set(compact('countries'));

		if ($this->request->is('ajax')) {
			$this->render('pagination_container');
		}
	}

	/**
	 * Using infinitescroll
	 *
	 * @return void
	 */
	public function endlessScroll() {
		$this->loadModel('Data.Countries');

		$countries = $this->paginate('Countries');
		$this->set(compact('countries'));

		if ($this->request->is('ajax')) {
			$this->render('endless_scroll_container');
		}
	}

	/**
	 * @return void
	 */
	public function table() {
		$this->loadModel('Data.Countries');

		$countries = $this->paginate('Countries');
		$this->set(compact('countries'));
	}

	/**
	 * Dummy delete
	 *
	 * @param int|null $id
	 * @return \Cake\Http\Response|null
	 */
	public function tableDelete($id = null) {
		$false = false;
		if ($false) {
			$country = $this->Countries->get($id);
			$this->Countries->delete($country);
		}

		$this->Flash->success('Deleted (simulated)!');

		return $this->redirect(['action' => 'table']);
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
	public function chainedDropdowns() {
		$this->loadModel('Users');
		$user = $this->Users->newEntity();

		if ($this->request->is('post')) {
			$this->Users->getValidator()->add('state_id', 'numeric', [
				'rule' => 'numeric',
				'message' => 'Please select something'
			]);
			$user = $this->Users->patchEntity($user, $this->request->getData());
		}

		$this->CountryStateHelper->provideData(false, 'User');
		$this->set(compact('user'));
	}

	/**
	 * My own convention was to suffix AJAX only actions with "_ajax".
	 * Not really necessary, but can maybe distinguish such actions from
	 * the normal ones.
	 *
	 * This method provides the AJAX data chained_dropdowns() needs.
	 *
	 * @return void
	 * @throws \Cake\Http\Exception\NotFoundException
	 */
	public function countryStates() {
		$this->request->allowMethod('ajax');
		$id = $this->request->getQuery('id');
		if (!$id) {
			throw new NotFoundException();
		}

		$this->viewBuilder()->className('Ajax.Ajax');

		$this->loadModel('Data.States');
		$states = $this->States->getListByCountry($id);

		$this->set(compact('states'));
	}

	/**
	 * Show how AJAX plugin can work with forms just as normal PRG behavior would.
	 *
	 * @return \Cake\Http\Response|null
	 */
	public function form() {
		$this->loadModel('Users');
		$user = $this->Users->newEntity();

		if ($this->request->is(['post', 'put', 'patch'])) {
			$user = $this->Users->patchEntity($user, $this->request->getData());
			if (!$user->errors()) {
				$this->Flash->success('Simulated save.');
				return $this->redirect(['action' => 'form']);
			}
			$this->Flash->error('Form not yet valid.');
		}

		$this->set(compact('user'));
	}

	/**
	 * Show how redirecting works when AJAX is involved:
	 * It will requestAction() the redirect instead of actually redirecting.
	 *
	 * @return \Cake\Http\Response|null
	 */
	public function redirecting() {
		if ($this->request->is('post')) {
			// Do sth like saving data
			if (!$this->request->is('ajax')) {
				$this->Flash->success('Yeah, that was a normal POST and redirect (PRG).');
			}
			return $this->redirect(['action' => 'index']);
		}
	}

	/**
	 * Show how redirecting works when AJAX is involved using Ajax component and view class.
	 * It will not follow the redirect, but instead return it along with messages sent.
	 *
	 * @return \Cake\Http\Response|null
	 */
	public function redirectingPrevented() {
		if ($this->request->is('post')) {
			// Do sth like saving data

			$this->Flash->success('Yeah, that was a normal POST and redirect (PRG).');

			return $this->redirect(['action' => 'index']);
		}
	}

}
