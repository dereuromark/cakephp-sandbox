<?php
App::uses('ToolsAppController', 'Tools.Controller');

class CountryProvincesController extends ToolsAppController {

	//public $helpers = array('Html', 'Form');
	public $paginate = array('order' => array('CountryProvince.modified' => 'DESC'));

	public function beforeFilter() {
		parent::beforeFilter();

		if (isset($this->Auth)) {
			$this->Auth->allow('index', 'update_select');
		}
	}

	/**
	 * Ajax function
	 * new: optional true/false for default field label
	 */
	public function update_select($id = null) {
		//$this->autoRender = false;
		if (!$this->request->is('post') || !$this->request->is('ajax')) {
			die(__('not a valid request'));
		}
		$this->layout = 'ajax';
		$countryProvinces = $this->CountryProvince->getListByCountry($id);
		$defaultFieldLabel = 'pleaseSelect';
		if (!empty($this->request->params['named']['optional'])) {
			$defaultFieldLabel = 'doesNotMatter';
		}

		$this->set(compact('countryProvinces', 'defaultFieldLabel'));
	}

	public function index($cid = null) {
		$this->CountryProvince->recursive = 0;
		$this->paginate['order'] = array('CountryProvince.name' => 'ASC');
		$this->paginate['conditions'] = array('Country.status' => 1);

		$cid = $this->_processCountry($cid);

		$countryProvinces = $this->paginate();

		$countries = $this->CountryProvince->Country->active('list');
		$this->set(compact('countryProvinces', 'countries'));
	}

	/****************************************************************************************
	* ADMIN functions
	****************************************************************************************/

	public function admin_update_coordinates($id = null) {
		set_time_limit(120);
		$res = $this->CountryProvince->updateCoordinates($id);
		if (!$res) {
			$this->Common->flashMessage(__('coordinates not updated'), 'error');
		} else {
			$this->Common->flashMessage(__('coordinates %s updated', $res), 'success');
		}

		$this->autoRender = false;
		return $this->redirect(array('action' => 'index'));
	}

	public function admin_index($cid = null) {
		$cid = $this->_processCountry($cid);

		$this->CountryProvince->recursive = 0;
		$countryProvinces = $this->paginate();
		$countries = $this->CountryProvince->Country->find('list');

		$this->set(compact('countryProvinces', 'countries'));
		$this->Common->loadHelper(array('Tools.GoogleMapV3'));
	}

	public function admin_view($id = null) {
		$this->CountryProvince->recursive = 0;
		if (empty($id)) {
			$this->Common->flashMessage(__('record invalid'), 'error');
			return $this->redirect(array('action' => 'index'));
		}
		$countryProvince = $this->CountryProvince->get($id);
		if (empty($countryProvince)) {
			$this->Common->flashMessage(__('record not exists'), 'error');
			return $this->redirect(array('action' => 'index'));
		}
		$this->set(compact('countryProvince'));
	}

	public function admin_add() {
		if ($this->Common->isPosted()) {
			$this->CountryProvince->create();
			if ($this->CountryProvince->save($this->request->data)) {
				$id = $this->CountryProvince->id;
				$name = $this->request->data['CountryProvince']['name'];
				$this->Common->flashMessage(__('record add %s saved', h($name)), 'success');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Common->flashMessage(__('record add not saved'), 'error');
			}
		} else {
			$cid = $this->Session->read('CountryProvince.cid');
			if (!empty($cid)) {
				$this->request->data['CountryProvince']['country_id'] = $cid;
			}
		}
		$countries = $this->CountryProvince->Country->find('list');
		$this->set(compact('countries'));
	}

	public function admin_edit($id = null) {
		if (empty($id)) {
			$this->Common->flashMessage(__('record invalid'), 'error');
			return $this->redirect(array('action' => 'index'));
		}
		if ($this->Common->isPosted()) {
			if ($this->CountryProvince->save($this->request->data)) {
				$name = $this->request->data['CountryProvince']['name'];
				$this->Common->flashMessage(__('record edit %s saved', h($name)), 'success');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Common->flashMessage(__('record edit not saved'), 'error');
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->CountryProvince->get($id);
			if (empty($this->request->data)) { # still no record found
				$this->Common->flashMessage(__('record not exists'), 'error');
				return $this->redirect(array('action' => 'index'));
			}
		}
		$countries = $this->CountryProvince->Country->find('list');
		$this->set(compact('countries'));
	}

	public function admin_delete($id = null) {
		if (!$this->Common->isPosted()) {
			throw new MethodNotAllowedException();
		}
		if (empty($id)) {
			$this->Common->flashMessage(__('record invalid'), 'error');
			return $this->redirect(array('action' => 'index'));
		}
		$res = $this->CountryProvince->find('first', array('fields' => array('id', 'name'), 'conditions' => array('CountryProvince.id' => $id)));
		if (empty($res)) {
			$this->Common->flashMessage(__('record del not exists'), 'error');
			return $this->redirect(array('action' => 'index'));
		}

		$name = $res['CountryProvince']['name'];
		if ($this->CountryProvince->delete($id)) {
			$this->Common->flashMessage(__('record del %s done', h($name)), 'success');
			return $this->redirect(array('action' => 'index'));
		} else {
			$this->Common->flashMessage(__('record del %s not done exception', $name), 'error');
			return $this->redirect(array('action' => 'index'));
		}
	}

	/****************************************************************************************
	* protected/internal functions
	****************************************************************************************/

	/**
	 * For both index views
	 */
	public function _processCountry($cid) {
		$saveCid = true;
		if (empty($cid)) {
			$saveCid = false;
			$cid = $this->Session->read('CountryProvince.cid');
		}
		if (!empty($cid) && $cid < 0) {
			$this->Session->delete('CountryProvince.cid');
			$cid = null;
		} elseif (!empty($cid) && $saveCid) {
			$this->Session->write('CountryProvince.cid', $cid);
		}

		if (!empty($cid)) {
			$this->paginate = Set::merge($this->paginate, array('conditions' => array('country_id' => $cid)));
			$this->request->data['Filter']['id'] = $cid;
		}
	}

}
