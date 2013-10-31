<?php
App::uses('ToolsAppController', 'Tools.Controller');

class LanguagesController extends ToolsAppController {

	public $paginate = array('order' => array('Language.name' => 'ASC'));

	public function beforeFilter() {
		parent::beforeFilter();
	}

/****************************************************************************************
 * USER functions
 ****************************************************************************************/

	/*
	public function index() {
		$this->Language->recursive = 0;
		$languages = $this->paginate();
		$this->set(compact('languages'));
	}

	public function view($id = null) {
		if (empty($id) || !($language = $this->Language->find('first', array('conditions'=>array('Language.id'=>$id))))) {
			$this->Common->flashMessage(__('invalid record'), 'error');
			return $this->Common->autoRedirect(array('action' => 'index'));
		}
		$this->set(compact('language'));
	}
	*/

/****************************************************************************************
 * ADMIN functions
 ****************************************************************************************/

	/**
	 * Should only be done once at the very beginning
	 */
	public function admin_import_from_core() {
		if (!empty($this->request->params['named']['reset'])) {
			$this->Language->truncate();
		}
		//$languages = $this->Language->iso3ToIso2();
		$languages = $this->Language->catalog();
		$count = 0;
		$errors = array();
		foreach ($languages as $language) {
			if (!($code = $this->Language->iso3ToIso2($language['localeFallback']))) {
				$code = '';
			}
			$data = array(
				'name' => $language['language'],
				'ori_name' => $language['language'],
				'code' => $code,
				'locale' => $language['locale'],
				'locale_fallback' => $language['localeFallback'],
				'direction' => $language['direction']
			);
			$this->Language->create();
			if ($this->Language->save($data)) {
				$count++;
			} else {
				$errors[] = array('data' => $language, 'errors' => $this->Language->validationErrors);
			}
		}

		$this->Common->flashMessage($count . ' of ' . count($languages) . ' ' . __('languages added'), 'success');

		$errorMessage = array();
		foreach ($errors as $error) {
			$errorMessage[] = $error['data']['language'] . ' (' . returns($error['errors']) . ')';
		}
		$this->Common->flashMessage(__('not added') . ' ' . implode(', ', $errorMessage), 'warning');
		return $this->redirect(array('action' => 'index'));
		//pr($errors);
	}

	/**
	 * http://www.loc.gov/standards/iso639-2/php/code_list.php
	 */
	public function admin_compare_to_iso_list() {
		$isoList = $this->Language->getOfficialIsoList();

		$languages = $this->Language->find('all', array());

		$this->set(compact('isoList', 'languages'));
	}

	/**
	 * http://www.loc.gov/standards/iso639-2/php/code_list.php
	 */
	public function admin_compare_iso_list_to_core() {
		$isoList = $this->Language->getOfficialIsoList();

		$languages = $this->Language->catalog();
		$locales = array();
		foreach ($languages as $key => $value) {
			if (strlen($key) === 2) {
				$locales[$key] = $value;
				$locales[$key]['regional'] = array();
				continue;
			}
			if (strlen($key) === 1) {
				//$locales[$key] = $value;
				//$locales[$key]['deprecated'] = 1;
				continue;
			}
			$baseLocale = substr($key, 0, 2);
			if (!isset($locales[$baseLocale])) {
				$locales[$baseLocale] = array('missing_base' => 1);
			}
			$locales[$baseLocale]['regional'][] = $value;
		}

		//die(debug($locales));

		$this->set(compact('isoList', 'languages', 'locales'));
	}

	public function admin_set_primary_languages_active() {
		$languages = $this->Language->getPrimaryLanguages('list');
		$this->Language->updateAll(array('status' => Language::STATUS_ACTIVE), array('id' => array_keys($languages)));

		$this->Common->flashMessage(__('%s of %s set active', $this->Language->getAffectedRows(), count($languages)), 'success');
		return $this->redirect(array('action' => 'index'));
	}

/* probs:

Array
(
	[0] => Array
		(
			[data] => Array
				(
					[language] => Greek
					[locale] => gre
					[localeFallback] => gre
					[charset] => utf-8
					[direction] => ltr
				)

			[errors] => Array
				(
					[locale] => valErrRecordNameExists
				)

		)

	[1] => Array
		(
			[data] => Array
				(
					[language] => Indonesian
					[locale] => ind
					[localeFallback] => ind
					[charset] => utf-8
					[direction] => ltr
				)

			[errors] => Array
				(
					[locale] => valErrRecordNameExists
				)

		)

	[2] => Array
		(
			[data] => Array
				(
					[language] => Dutch (Standard)
					[locale] => dut
					[localeFallback] => dut
					[charset] => utf-8
					[direction] => ltr
				)

			[errors] => Array
				(
					[locale] => valErrRecordNameExists
				)

		)

	[3] => Array
		(
			[data] => Array
				(
					[language] => Polish
					[locale] => pol
					[localeFallback] => pol
					[charset] => utf-8
					[direction] => ltr
				)

			[errors] => Array
				(
					[locale] => valErrRecordNameExists
				)

		)

)

*/

	public function admin_index() {
		$this->Language->recursive = 0;
		$languages = $this->paginate();
		$this->set(compact('languages'));
	}

	public function admin_view($id = null) {
		if (empty($id) || !($language = $this->Language->find('first', array('conditions' => array('Language.id' => $id))))) {
			$this->Common->flashMessage(__('invalid record'), 'error');
			return $this->Common->autoRedirect(array('action' => 'index'));
		}
		$this->set(compact('language'));
	}

	public function admin_add() {
		if ($this->Common->isPosted()) {
			$this->Language->create();
			if ($this->Language->save($this->request->data)) {
				$var = $this->request->data['Language']['name'];
				$this->Common->flashMessage(__('record add %s saved', h($var)), 'success');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Common->flashMessage(__('formContainsErrors'), 'error');
			}
		}
	}

	public function admin_edit($id = null) {
		if (empty($id) || !($language = $this->Language->find('first', array('conditions' => array('Language.id' => $id))))) {
			$this->Common->flashMessage(__('invalid record'), 'error');
			return $this->Common->autoRedirect(array('action' => 'index'));
		}
		if ($this->Common->isPosted()) {
			if ($this->Language->save($this->request->data)) {
				$var = $this->request->data['Language']['name'];
				$this->Common->flashMessage(__('record edit %s saved', h($var)), 'success');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Common->flashMessage(__('formContainsErrors'), 'error');
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $language;
		}
	}

	public function admin_delete($id = null) {
		if (!$this->Common->isPosted()) {
			throw new MethodNotAllowedException();
		}
		if (empty($id) || !($language = $this->Language->find('first', array('conditions' => array('Language.id' => $id), 'fields' => array('id', 'name'))))) {
			$this->Common->flashMessage(__('invalid record'), 'error');
			return $this->Common->autoRedirect(array('action' => 'index'));
		}
		if ($this->Language->delete($id)) {
			$var = $language['Language']['name'];
			$this->Common->flashMessage(__('record del %s done', h($var)), 'success');
			return $this->redirect(array('action' => 'index'));
		}
		$this->Common->flashMessage(__('record del %s not done exception', h($var)), 'error');
		return $this->Common->autoRedirect(array('action' => 'index'));
	}

/****************************************************************************************
 * protected/interal functions
 ****************************************************************************************/

/****************************************************************************************
 * deprecated/test functions
 ****************************************************************************************/

}
