<?php
App::uses('DataAppController', 'Data.Controller');

class CountriesController extends DataAppController {

	public $paginate = array('order' => array('Country.sort' => 'DESC'));

	public function beforeFilter() {
		parent::beforeFilter();

		if ($specific = Configure::read('Country.image_path')) {
			$this->imageFolder = WWW_ROOT . 'img' . DS . $specific . DS;
		} else {
			$this->imageFolder = CakePlugin::path('Data') . DS . 'webroot' . DS . 'img' . DS . 'country_flags' . DS;
		}

		if (isset($this->Auth)) {
			$this->Auth->allow('index');
			/*
			$this->Auth->actionMap = array_merge($this->Auth->actionMap, array(
				'admin_down' => 'edit',
				'admin_up' => 'edit'
			));
			*/
		}
	}

	/**
	 * CountriesController::index()
	 *
	 * @return void
	 */
	public function index() {
		$this->Country->recursive = 0;
		$countries = $this->paginate();
		$this->set(compact('countries'));
	}

	public function _icons() {
		$useCache = true;
		if (!empty($this->request->params['named']['reset'])) {
			$useCache = false;
		}

		if ($useCache && ($iconNames = Cache::read('country_icon_names')) !== false) {
			$this->Common->flashMessage('Cache Used', 'info');
			return $iconNames;
		}
		App::uses('Folder', 'Utility');
		$handle = new Folder($this->imageFolder);
		$icons = $handle->read(true, true);

		$iconNames = array();
		foreach ($icons[1] as $icon) { # only use files (not folders)
			$iconNames[] = strtoupper(extractPathInfo('filename', $icon));
		}
		Cache::write('country_icon_names', $iconNames);

		return $iconNames;
	}

	/**
	 * CountriesController::admin_update_coordinates()
	 *
	 * @param mixed $id
	 * @return
	 */
	public function admin_update_coordinates($id = null) {
		set_time_limit(120);
		$res = $this->Country->updateCoordinates($id);
		if (!$res) {
			$this->Common->flashMessage(__('coordinates not updated'), 'error');
		} else {
			$this->Common->flashMessage(__('coordinates %s updated', $res), 'success');
		}

		$this->autoRender = false;
		return $this->redirect(array('action' => 'index'));
	}

	/**
	 * Check for missing or unused country flag icons
	 */
	public function admin_icons() {
		$icons = $this->_icons();

		$countries = $this->Country->find('all', array('fields' => array('id', 'name', 'iso2', 'iso3')));

		$usedIcons = array();

		# countries without icons
		$contriesWithoutIcons = array();
		foreach ($countries as $country) {
			$icon = strtoupper($country['Country']['iso2']);
			if (!in_array($icon, $icons)) {
				$contriesWithoutIcons[] = $country;
			} else {
				$key = array_keys($icons, $icon);
				$usedIcons[] = $icons[$key[0]];
			}
		}

		# icons without countries
		$iconsWithoutCountries = array();
		$iconsWithoutCountries = array_diff($icons, $usedIcons);
		//pr($iconsWithoutCountries);

		$this->set(compact('icons', 'countries', 'contriesWithoutIcons', 'iconsWithoutCountries'));
	}

	public function admin_import() {
		if ($this->Common->isPosted()) {

			if (!empty($this->request->data['Form'])) {
				$count = 0;
				foreach ($this->request->data['Form'] as $key => $val) {
					$this->Country->create();
					$data = array('iso3' => $val['iso3'], 'iso2' => $val['iso2'], 'name' => $val['name']);
					if (empty($val['confirm'])) {
						# do nothing
					} elseif ($this->Country->save($data)) {
						$count++;
						unset($this->request->data['Form'][$key]);
					} else {
						//$this->request->data['Form'][$key]['confirm'] = 0;
						$this->request->data['Error'][$key] = $this->Country->validationErrors;
					}

				}
				$this->Common->flashMessage(__('record import %s saved', $count), 'success');

			} else {

				$list = $this->request->data['Country']['import_content'];

				if (!empty($this->request->data['Country']['import_separator_custom'])) {
					$separator = $this->request->data['Country']['import_separator_custom'];
					$separator = str_replace(array('{SPACE}', '{TAB}'), array(Country::separators(SEPARATOR_SPACE, true), Country::separators(SEPARATOR_TAB, true)), $separator);

				} else {
					$separator = $this->request->data['Country']['import_separator'];
					$separator = Country::separators($separator, true);
				}
				# separate list into single records

				$countries = CommonComponent::parseList($list, $separator, false, false);
				if (empty($countries)) {
					$this->Country->invalidate('import_separator', 'falscher Separator');
				} elseif (!empty($this->request->data['Country']['import_pattern'])) {
					$pattern = str_replace(array('{SPACE}', '{TAB}'), array(Country::separators(SEPARATOR_SPACE, true), Country::separators(SEPARATOR_TAB, true)), $this->request->data['Country']['import_pattern']);
					# select part that matches %name
					foreach ($countries as $key => $danceStep) {
						$tmp = sscanf($danceStep, $pattern); # returns array
						# write back into $countries array
						if (!empty($tmp[2])) {
							$this->request->data['Form'][$key] = array('name' => $tmp[2], 'confirm' => 1);
							if (!empty($tmp[1])) {
								$this->request->data['Form'][$key]['iso2'] = $tmp[1];
							}
							if (!empty($tmp[0])) {
								$this->request->data['Form'][$key]['iso3'] = $tmp[0];
							}
						}
						$countries[$key] = $tmp;
					}

					if (empty($this->request->data['Form'])) {
						$this->Country->invalidate('import_pattern', 'falsches Muster');
					}
				} else {
					foreach ($countries as $key => $country) {
						$this->request->data['Form'][$key] = array('name' => $country, 'confirm' => 1);
					}
				}

			}

			$this->set(compact('countries'));

		}
	}

	public function admin_index() {
		$countries = $this->paginate();
		$this->set(compact('countries'));

		$this->helpers = array_merge($this->helpers, array('Data.GoogleMapV3'));
	}

	public function admin_view($id = null) {
		$this->Country->recursive = 0;
		$id = (int)$id;
		if ($id <= 0) {
			$this->Common->flashMessage(__('record invalid'), 'error');
			return $this->redirect(array('action' => 'index'));
		}
		$country = $this->Country->get($id);
		if (empty($country)) {
			$this->Common->flashMessage(__('record not exists'), 'error');
			return $this->redirect(array('action' => 'index'));
		}
		$this->set(compact('country'));
	}

	public function admin_add() {
		if ($this->Common->isPosted()) {
			$this->Country->create();
			if ($this->Country->save($this->request->data)) {
				$id = $this->Country->id;
				//$name = $this->request->data['Country']['name'];
				$this->Common->flashMessage(__('record add %s saved', $id), 'success');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Common->flashMessage(__('record add not saved'), 'error');
			}
		}
	}

	public function admin_edit($id = null) {
		if (!$id || !($country = $this->Country->get($id))) {
			$this->Common->flashMessage(__('record invalid'), 'error');
			return $this->redirect(array('action' => 'index'));
		}
		if ($this->Common->isPosted()) {
			if ($this->Country->save($this->request->data)) {
				$name = $country['Country']['name'];
				$this->Common->flashMessage(__('record edit %s saved', h($name)), 'success');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Common->flashMessage(__('record edit not saved'), 'error');
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $country;
			if (empty($this->request->data)) { # still no record found
				$this->Common->flashMessage(__('record not exists'), 'error');
				return $this->redirect(array('action' => 'index'));
			}
		}
	}

	public function admin_delete($id = null) {
		$id = (int)$id;
		if ($id <= 0) {
			$this->Common->flashMessage(__('record invalid'), 'error');
			return $this->redirect(array('action' => 'index'));
		}
		$res = $this->Country->find('first', array('fields' => array('id'), 'conditions' => array('Country.id' => $id)));
		if (empty($res)) {
			$this->Common->flashMessage(__('record del not exists'), 'error');
			return $this->redirect(array('action' => 'index'));
		}

		//$name = $res['Country']['name'];
		if ($this->Country->delete($id)) {
			$this->Common->flashMessage(__('record del %s done', $id), 'success');
			return $this->redirect(array('action' => 'index'));
		} else {
			$this->Common->flashMessage(__('record del %s not done exception', $id), 'error');
			return $this->redirect(array('action' => 'index'));
		}
	}

	public function admin_up($id = null) {
		if (empty($id) || !($navigation = $this->Country->find('first', array('conditions' => array('Country.id' => $id))))) {
			$this->Common->flashMessage(__('invalid record'), 'error');
			return $this->Common->autoRedirect(array('action' => 'index'));
		}
		$this->Country->moveDown($id, 1);
		return $this->redirect(array('action' => 'index'));
	}

	public function admin_down($id = null) {
		if (empty($id) || !($navigation = $this->Country->find('first', array('conditions' => array('Country.id' => $id))))) {
			$this->Common->flashMessage(__('invalid record'), 'error');
			return $this->Common->autoRedirect(array('action' => 'index'));
		}
		$this->Country->moveUp($id, 1);
		return $this->redirect(array('action' => 'index'));
	}

	/**
	 * Validate
	 * - abbr
	 * - zip length/regexp ?
	 * - EU ?
	 * - lat/lng available and correct ?
	 * - iso codes
	 * - address format?
	 * - timezones and summertime
	 *
	 * resources:
	 * - http://www.iso.org/iso/list-en1-semic-3.txt
	 * - http://www.worldtimeserver.com/country.html - http://api.geonames.org/timezone?lat=47.01&lng=10.2&username=demo
	 * - http://www.geonames.org/countries/ - http://api.geonames.org/postalCodeCountryInfo?username=demo
	 * - http://www.pixelenvision.com/1708/zip-postal-code-validation-regex-php-code-for-12-countries/
	 *
	 */
	public function admin_validate() {
		$countries = $this->Country->find('all');

		//TODO.
		$this->set(compact('countries'));
	}

}
