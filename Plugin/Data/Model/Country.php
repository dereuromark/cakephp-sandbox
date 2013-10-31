<?php
App::uses('DataAppModel', 'Data.Model');
App::uses('GeocodeLib', 'Data.Lib');

class Country extends DataAppModel {

	public $order = array('Country.sort' => 'DESC', 'Country.name' => 'ASC');

	public $actsAs = array('Tools.Sortable');

	public $validate = array(
		'name' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Manditory field',
				'last' => true,
			),
			'isUnique' => array(
				'rule' => array('isUnique'),
				'message' => 'record (with this name) already exists',
			),
		),
		'ori_name' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Manditory field',
				'last' => true,
			),
			'isUnique' => array(
				'rule' => array('isUnique'),
				'message' => 'record (with this name) already exists',
			),
		),
		'iso2' => array(
			'isUnique' => array(
				'rule' => array('isUnique'),
				'allowEmpty' => true,
				'message' => 'record (with this name) already exists',
			),
		),
		'iso3' => array(
			'isUnique' => array(
				'rule' => array('isUnique'),
				'allowEmpty' => true,
				'message' => 'record (with this name) already exists',
			),
		),
		'country_code' => array('numeric'),
		//'special' => array('notempty'),
		//'sort' => array('numeric')
	);

	public $hasMany = array(
		'CountryProvince' => array(
			'className' => 'Data.CountryProvince',
			'foreignKey' => 'country_id',
			'dependent' => true, # !!!
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
		),
		'State' => array(
			'className' => 'Data.State',
			'foreignKey' => 'country_id',
			'dependent' => true, # !!!
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
		),
/*
		'Location' => array(
			'className' => 'Location',
			'foreignKey' => 'country_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
		)
*/
	);

	public function __construct($id = false, $table = false, $ds = null) {
		if (Configure::read('Country.provinces') === false) {
			unset($this->hasMany['CountryProvince']);
		}
		if (Configure::read('Country.State') !== true) {
			unset($this->hasMany['State']);
		}

		parent::__construct($id, $table, $ds);
	}

	public function active($type = 'all', $customOptions = array()) {
		$options = array('conditions' => array($this->alias . '.status' => 1), );
		if (!empty($customOptions)) {
			$options = array_merge($options, $customOptions);
		}
		return $this->find($type, $options);
	}

	public function getList() {
		return $this->find('list', array(
			//'conditions'=>array('active'=>1),
		));
	}

	/**
	 * Lat and lng + abbr if available!
	 *
	 * @param id
	 * - NULL: update all records with missing coordinates only
	 * - otherwise: specific update
	 */
	public function updateCoordinatesNew($id = null) {
		$Geocoder = new GeocodeLib();

		$override = false;
		if ($id == -1) {
			$id = '';
			$override = true;
		}

		if (!empty($id)) {
			$res = $this->find('first', array('conditions' => array($this->alias . '.id' => $id), 'contain' => array()));
			if (!empty($res[$this->alias]['ori_name']) && $Geocoder->geocode($res[$this->alias]['ori_name']) || $res[$this->alias]['name'] != $res[$this->alias]['ori_name'] && $Geocoder->geocode($res[$this->alias]['name'])) {

				$data = $Geocoder->getResult();
				//pr($data); die();
				$saveArray = array('lat' => $data['lat'], 'lng' => $data['lng']);

				if (!empty($data['country_code']) && mb_strlen($data['country_code']) === 3 && preg_match('/^([A-Z])*$/', $data['country_code'])) {
					$saveArray['iso3'] = $data['country_code'];
					die(returns($saveArray));

				} elseif (!empty($data['country_code']) && mb_strlen($data['country_code']) === 2 && preg_match('/^([A-Z])*$/', $data['country_code'])) {
					$saveArray['iso2'] = $data['country_code'];
					die(returns($saveArray));
				}

				$this->id = $id;
				if (!$this->save($saveArray, true, array('lat', 'lng', 'iso2', 'iso3'))) {
					echo returns($this->id);
					pr($res); pr($data); pr($saveArray); die(returns($this->validationErrors));
				}
				return true;
			}
		} else {

			$conditions = array();
			if (!$override) {
				$conditions = array($this->alias . '.lat' => 0, $this->alias . '.lng' => 0);
			}

			$results = $this->find('all', array('conditions' => $conditions, 'contain' => array()));

			$count = 0;
			foreach ($results as $res) {
				if (!empty($res[$this->alias]['ori_name']) && $Geocoder->geocode($res[$this->alias]['ori_name']) || $res[$this->alias]['name'] != $res[$this->alias]['ori_name'] && $Geocoder->geocode($res[$this->alias]['name'])) {

					$data = $Geocoder->getResult();
					echo returns($res);
					echo returns($data); die();
					# seems to be very problematic: country "Georgien" results in "Georgia, USA"

					$saveArray = array();
					if (isset($data['lat']) && isset($data['lng'])) {
						$saveArray = array('lat' => $data['lat'], 'lng' => $data['lng']);
					}

					if (!empty($data['country_code']) && mb_strlen($data['country_code']) === 3 && preg_match('/^([A-Z])*$/', $data['country_code'])) {
						$saveArray['iso3'] = $data['country_code'];
						//die(returns($saveArray));

					} elseif (!empty($data['country_code']) && mb_strlen($data['country_code']) === 2 && preg_match('/^([A-Z])*$/', $data['country_code'])) {
						$saveArray['iso2'] = $data['country_code'];
						//die(returns($saveArray));
					}

					$this->id = $res[$this->alias]['id'];
					if ($this->save($saveArray, true, array('lat', 'lng', 'iso2', 'iso3'))) {
						$count++;

						if (!empty($saveArray['iso2']) && $saveArray['iso2'] != $res[$this->alias]['iso2']) {
				$this->log('Iso2 for country \'' . $data['country'] . '\' changed from \'' . $res[$this->alias]['iso2'] . '\' to \'' . $saveArray['iso2'] . '\'', LOG_NOTICE);
					}
					if (!empty($saveArray['iso3']) && $saveArray['iso3'] != $res[$this->alias]['iso3']) {
				$this->log('Iso3 for country \'' . $data['country'] . '\' changed from \'' . $res[$this->alias]['iso3'] . '\' to \'' . $saveArray['iso3'] . '\'', LOG_NOTICE);
					}

					} else {
						//pr($data); pr($Geocoder->debug()); die();
					}
					$Geocoder->pause();
				}
			}

			return $count;
		}

		return false;
	}

	//TODO: test

	public function updateAbbr($id = null) {
		App::uses('GeocodeLib', 'Tools.Lib');
		$Geocoder = new GeocodeLib();

		$override = false;
		if ($id == -1) {
			$id = '';
			$override = true;
		}

		if (!empty($id)) {
			$res = $this->find('first', array('conditions' => array($this->alias . '.id' => $id), 'contain' => array()));
			if (!empty($res[$this->alias]['ori_name']) && $Geocoder->geocode($res[$this->alias]['ori_name']) || $res[$this->alias]['name'] != $res[$this->alias]['ori_name'] && $Geocoder->geocode($res[$this->alias]['name'])) {

			}
		} else {
			$conditions = array();
			if (!$override) {
				$conditions = array($this->alias . '.iso2' => ''); # right now only iso2
			}

			$results = $this->find('all', array('conditions' => $conditions, 'contain' => array()));

			$count = 0;
			foreach ($results as $res) {
				if (!empty($res[$this->alias]['ori_name']) && $Geocoder->geocode($res[$this->alias]['ori_name']) || $res[$this->alias]['name'] != $res[$this->alias]['ori_name'] && $Geocoder->geocode($res[$this->alias]['name'])) {

					$data = $Geocoder->getResult();
					echo returns($res);
					echo returns($data); die();
					# seems to be very problematic: country "Georgien" results in "Georgia, USA"

					$saveArray = array();
					if (!empty($data['country_code']) && mb_strlen($data['country_code']) === 3 && preg_match('/^([A-Z])*$/', $data['country_code'])) {
						$saveArray['iso3'] = $data['country_code'];
						//die(returns($saveArray));

					} elseif (!empty($data['country_code']) && mb_strlen($data['country_code']) === 2 && preg_match('/^([A-Z])*$/', $data['country_code'])) {
						$saveArray['iso2'] = $data['country_code'];
						//die(returns($saveArray));
					}

					$this->id = $res[$this->alias]['id'];
					if ($this->save($saveArray, true, array('iso2', 'iso3'))) {
						$count++;

						if (!empty($saveArray['iso2']) && $saveArray['iso2'] != $res[$this->alias]['iso2']) {
				$this->log('Iso2 for country \'' . $data['country'] . '\' changed from \'' . $res[$this->alias]['iso2'] . '\' to \'' . $saveArray['iso2'] . '\'', LOG_NOTICE);
					}
					if (!empty($saveArray['iso3']) && $saveArray['iso3'] != $res[$this->alias]['iso3']) {
				$this->log('Iso3 for country \'' . $data['country'] . '\' changed from \'' . $res[$this->alias]['iso3'] . '\' to \'' . $saveArray['iso3'] . '\'', LOG_NOTICE);
					}

					} else {
						//pr($data); pr($Geocoder->debug()); die();
					}
					$Geocoder->pause();
				}
			}

			return $count;
		}

		return false;
	}

	/**
	 * @param id
	 * - NULL: update all records with missing coordinates only
	 * - otherwise: specific update
	 * @deprecated but seems to have better lat/lng for countries...
	 */
	public function updateCoordinates($id = null) {
		App::uses('GeocodeLib', 'Tools.Lib');
		$Geocoder = new GeocodeLib();
		//$Geocoder->setup();

		$override = false;
		if ($id == -1) {
			$id = '';
			$override = true;
		}

		$conditions = array();
		if (!$override) {
			$conditions = array($this->alias . '.lat' => 0, $this->alias . '.lng' => 0);
		}

		if (!empty($id)) {
			$res = $this->find('first', array('fields' => array($this->alias . '.id', $this->alias . '.name', $this->alias . '.ori_name'), 'conditions' => array($this->alias . '.id' => $id), 'contain' => array()));
			if (!empty($res[$this->alias]['ori_name']) && ($data = $Geocoder->geocode($res[$this->alias]['ori_name'])) || $res[$this->alias]['name'] != $res[$this->alias]['ori_name'] && ($data = $Geocoder->geocode($res[$this->alias]['name']))) {

				//echo returns($data); echo returns($Geocoder->debug()); die();

				$this->id = $id;
				$this->save($data, true, array('lat', 'lng'));
				return true;
			}
		} else {

			$results = $this->find('all', array('fields' => array($this->alias . '.id', $this->alias . '.name', $this->alias . '.ori_name'), 'conditions' => $conditions, 'contain' => array()));
			$count = 0;
			foreach ($results as $res) {
				if (!empty($res[$this->alias]['ori_name']) && ($data = $Geocoder->geocode($res[$this->alias]['ori_name'])) || $res[$this->alias]['name'] != $res[$this->alias]['ori_name'] && ($data = $Geocoder->geocode($res[$this->alias]['name']))) {
					//echo returns($data); echo returns($Geocoder->debug()); die();

					$this->id = $res[$this->alias]['id'];
					if ($this->save($data, true, array('lat', 'lng'))) {
						$count++;
					} else {
						//echo returns($data); echo returns($Geocoder->debug()); die();
					}
					$Geocoder->pause();
				}
			}

			return $count;
		}

		//$this->save($data, true, array('city','id','lat','lng'));
		return false;
	}

	/**
	 * Try to guess the country of the user
	 * - time sensitive (only works in a certain timeframe < 24h)
	 *
	 * @return integer country or -1 on error
	 */
	public function guessByIp($ip = null) {
		/*
		if ($ip === null) {
			$ip = env('REMOTE_ADDR');
		}
		if (empty($ip)) {
			return -1;
		}
		*/
		App::uses('GeolocateLib', 'Tools.Lib');
		$this->GeolocateLib = new GeolocateLib();
		if ($this->GeolocateLib->locate($ip)) {
			$country = $this->GeolocateLib->getResult('country_code'); # iso2
			if (!empty($country)) {
				$c = $this->field('id', array($this->alias . '.iso2' => $country));
				if (!empty($c)) {
					return $c;
				}
			}
		}
		return -1;
	}

	public function afterSave($created, $options = array()) {
		if ($created) {
			$this->updateCoordinates($this->id);
		}
	}

	//not in use

	public function getIdByIso($isoCode) {
		$match = array('DE' => 1, 'AT' => 2, 'CH' => 3);

		if (array_key_exists($isoCode = strtoupper($isoCode), $match)) {
			return $match[$isoCode];
		}
		return 0;
	}

	//not in use

	public function getIsoById($id, $default = '') {
		$match = array(1 => 'DE', 2 => 'AT', 3 => 'CH');

		if (array_key_exists($id, $match)) {
			return $match[$id];
		}
		return $default;
	}

	public function getDefaultCountry() {
		return $this->getIdByIso(TLD);
	}

	const STATUS_ACTIVE = 1;
	const STATUS_INACTIVE = 0;

}
