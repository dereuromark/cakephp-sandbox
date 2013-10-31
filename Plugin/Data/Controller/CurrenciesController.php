<?php
App::uses('ToolsAppController', 'Tools.Controller');
class CurrenciesController extends ToolsAppController {

	public $helpers = array('Tools.Numeric', 'Tools.FormExt');

	public $paginate = array('order' => array('Currency.base' => 'DESC', 'Currency.modified' => 'DESC'));

	public function beforeFilter() {
		parent::beforeFilter();
	}

/****************************************************************************************
 * USER functions
 ****************************************************************************************/

	/*
	public function index() {
		$this->Currency->recursive = 0;
		$currencies = $this->paginate();
		$this->set(compact('currencies'));
	}
	*/

	/*
	public function view($id = null) {
		$this->Currency->recursive = 0;
		if (empty($id)) {
			$this->Common->flashMessage(__('record invalid'),'error');
			return $this->Common->autoRedirect(array('action'=>'index'));
		}
		$currency = $this->Currency->get($id);
		if (empty($currency)) {
			$this->Common->flashMessage(__('record not exists'),'error');
			return $this->Common->autoRedirect(array('action'=>'index'));
		}
		$this->set(compact('currency'));
	}

	public function add() {
		if ($this->Common->isPosted()) {
			$this->Currency->create();
			if ($this->Currency->save($this->request->data)) {
				$id = $this->Currency->id;
				//$name = $this->request->data['Currency']['name'];
				$this->Common->flashMessage(__('record add %s saved', $id),'success');
				return $this->redirect(array('action'=>'index'));
			} else {
				$this->Common->flashMessage(__('record add not saved'),'error');
			}
		}
	}

	public function edit($id = null) {
		if (empty($id)) {
			$this->Common->flashMessage(__('record invalid'),'error');
			return $this->Common->autoRedirect(array('action'=>'index'));
		}
		if ($this->Common->isPosted()) {
			if ($this->Currency->save($this->request->data)) {
				//$name = $this->request->data['Currency']['name'];
				$this->Common->flashMessage(__('record edit %s saved', $id),'success');
				return $this->redirect(array('action'=>'index'));
			} else {
				$this->Common->flashMessage(__('record edit not saved'),'error');
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->Currency->get($id);
			if (empty($this->request->data)) { # still no record found
				$this->Common->flashMessage(__('record not exists'),'error');
				return $this->redirect(array('action'=>'index'));
			}
		}
	}

	public function delete($id = null) {
		if (!$this->Common->isPosted()) {
			throw new MethodNotAllowedException();
		}
		if (empty($id)) {
			$this->Common->flashMessage(__('record invalid'),'error');
			return $this->Common->autoRedirect(array('action'=>'index'));
		}
		$res = $this->Currency->find('first', array('fields'=>array('id'),'conditions'=>array('Currency.id'=>$id)));
		if (empty($res)) {
			$this->Common->flashMessage(__('record del not exists'),'error');
			return $this->Common->autoRedirect(array('action'=>'index'));
		}

		//$name = $res['Currency']['name'];
		if ($this->Currency->delete($id)) {
			$this->Common->flashMessage(__('record del %s done', $id),'success');
			return $this->Common->postRedirect(array('action'=>'index'));
		} else {
			$this->Common->flashMessage(__('record del %s not done exception', $id),'error');
			return $this->Common->autoRedirect(array('action'=>'index'));
		}
	}
*/

/****************************************************************************************
 * ADMIN functions
 ****************************************************************************************/

	//@deprecated

	public function admin_list() {
		$currencies = $this->Currency->availableCurrencies();
		$res = array();
		foreach ($currencies as $key => $currency) {
			$x = array('id' => $key, 'name' => $key);
			$res[] = $x;
		}

		echo json_encode(array('results' => $res));
		die();
	}

	public function admin_table() {
		$currencies = $this->Currency->availableCurrencies();
		$this->set(compact('currencies'));
	}

	public function admin_update() {
		$this->Currency->updateValues();
		$this->Common->flashMessage('Currencies Updated', 'success');
		return $this->Common->autoRedirect(array('action' => 'index'));
	}

	public function admin_index() {
		$this->Currency->recursive = 0;
		$currencies = $this->paginate();

		$baseCurrency = array();
		foreach ($currencies as $currency) {
			if ($currency['Currency']['base']) {
				$baseCurrency = $currency;
				break;
			}
		}
		if (empty($baseCurrency)) {
			$this->Common->flashMessage(__('noBaseCurrency'), 'warning');
		}

		$this->set(compact('baseCurrency', 'currencies'));
	}

	public function admin_view($id = null) {
		$this->Currency->recursive = 0;
		if (empty($id)) {
			$this->Common->flashMessage(__('record invalid'), 'error');
			return $this->Common->autoRedirect(array('action' => 'index'));
		}
		$currency = $this->Currency->get($id);
		if (empty($currency)) {
			$this->Common->flashMessage(__('record not exists'), 'error');
			return $this->Common->autoRedirect(array('action' => 'index'));
		}
		$this->set(compact('currency'));
	}

	public function admin_add() {
		if ($this->Common->isPosted()) {
			$this->Currency->create();
			if ($this->Currency->save($this->request->data)) {
				$id = $this->Currency->id;
				//$name = $this->request->data['Currency']['name'];
				$this->Common->flashMessage(__('record add %s saved', $id), 'success');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->request->data = $this->Currency->data;

				$this->Common->flashMessage(__('record add not saved'), 'error');
			}
		} else {
			$this->request->data['Currency']['decimal_places'] = 2;
		}

		$currencies = $this->Currency->currencyList();
		$this->set(compact('currencies'));
	}

	public function admin_edit($id = null) {
		if (empty($id)) {
			$this->Common->flashMessage(__('record invalid'), 'error');
			return $this->Common->autoRedirect(array('action' => 'index'));
		}
		if ($this->Common->isPosted()) {
			if ($this->Currency->save($this->request->data)) {
				//$name = $this->request->data['Currency']['name'];
				$this->Common->flashMessage(__('record edit %s saved', $id), 'success');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Common->flashMessage(__('record edit not saved'), 'error');
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->Currency->get($id);
			if (empty($this->request->data)) { # still no record found
				$this->Common->flashMessage(__('record not exists'), 'error');
				return $this->redirect(array('action' => 'index'));
			}
		}
	}

	public function admin_delete($id = null) {
		if (!$this->Common->isPosted()) {
			throw new MethodNotAllowedException();
		}
		if (empty($id)) {
			$this->Common->flashMessage(__('record invalid'), 'error');
			return $this->Common->autoRedirect(array('action' => 'index'));
		}
		$res = $this->Currency->find('first', array('fields' => array('id'), 'conditions' => array('Currency.id' => $id)));
		if (empty($res)) {
			$this->Common->flashMessage(__('record del not exists'), 'error');
			return $this->Common->autoRedirect(array('action' => 'index'));
		}

		//$name = $res['Currency']['name'];
		if ($this->Currency->delete($id)) {
			$this->Common->flashMessage(__('record del %s done', $id), 'success');
			return $this->redirect(array('action' => 'index'));
		} else {
			$this->Common->flashMessage(__('record del %s not done exception', $id), 'error');
			return $this->Common->autoRedirect(array('action' => 'index'));
		}
	}

	/**
	 * Set as primary (base)
	 */
	public function admin_base($id = null) {
		$this->_setAsPrimary($id);
	}

	public function _setAsPrimary($id) {
		if (!empty($id)) {
			$value = $this->Currency->setAsBase($id);
		}

		$name = '';
		if (!empty($value)) {
			$this->Common->flashMessage(__('set as primary %s done', h($name)), 'success');
		} else {
			$this->Common->flashMessage(__('set as primary not done exception', $name), 'error');

		}
		return $this->Common->autoRedirect(array('action' => 'index'));
	}

	/**
	 * Toggle - ajax
	 */
	public function admin_toggle($field = null, $id = null) {
		 $fields = array('active');

		if (!empty($field) && in_array($field, $fields) && !empty($id)) {
			$value = $this->{$this->modelClass}->toggleField($field, $id);

		}

		//$this->request->is('post') && $this->request->is('ajax')

		# http get request + redirect
		if (!$this->request->is('ajax')) {
			$this->Common->flashMessage(__('Saved'), 'success');
			return $this->Common->autoRedirect(array('action' => 'index'));
		}

		# ajax
		$model = $this->{$this->modelClass}->alias;
		$this->autoRender = false;
		if (isset($value)) {
			$this->set('ajaxToggle', $value);
			$this->set(compact('field', 'model'));

			$this->render('admin_toggle', 'ajax');
		}
	}

/****************************************************************************************
 * protected/internal functions
 ****************************************************************************************/

/****************************************************************************************
 * deprecated/test functions
 ****************************************************************************************/

}
