<?php
App::uses('DataAppModel', 'Data.Model');
class State extends DataAppModel {

	public $actsAs = array('Tools.Slugged' => array('case' => 'low', 'mode' => 'ascii', 'unique' => false, 'overwrite' => false));

	public $order = array('State.name' => 'ASC');

	public $validate = array(
		'country_id' => array('numeric'),
		'abbr' => array(
			'validateUnique' => array(
				'rule' => array('validateUnique', array('country_id')),
				'message' => 'valErrRecordNameExists',
				'allowEmpty' => true
			),
		),
		'name' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'valErrMandatoryField',
				'last' => true
			),
			'isUnique' => array(
				'rule' => array('validateUnique', array('country_id')),
				'message' => 'valErrRecordNameExists',
			),
		),
	);

	public $hasMany = array(
		'County' => array(
			'className' => 'Data.County',
			'foreignKey' => 'state_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
		)
	);

	public $belongsTo = array(
		'Country' => array(
			'className' => 'Data.Country',
			'foreignKey' => 'country_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public function getStateId($conditions) {
		if ($id = $this->field('id', $conditions)) {
			return $id;
		}
		$this->create();
		$this->set($conditions);

		if ($this->save(null, false)) {
			return $this->id;
		} else {
			die('ERROR: ' . returns($this->validationErrors));
		}
	}

	public function getListByCountry($cid = null) {
		if (empty($cid)) {
			return array();
		}
		return $this->find('list', array(
			'conditions' => array($this->alias . '.country_id' => $cid),
			'order' => array($this->alias . '.name' => 'ASC')
		));
	}

	public function afterSave($created, $options = array()) {
		if ($created) {
			$this->updateCoordinates($this->id);
		}
	}

	/**
	 * Lat and lng + abbr if available!
	 *
	 * @param id
	 * - NULL: update all records with missing coordinates only
	 * - otherwise: specific update
	 */
	public function updateCoordinates($id = null) {
		App::uses('GeocodeLib', 'Tools.Lib');
		$geocoder = new GeocodeLib();

		$override = false;
		if ($id == -1) {
			$id = '';
			$override = true;
		}

		if (!empty($id)) {
			$res = $this->find('first', array('conditions' => array($this->alias . '.id' => $id), 'contain' => array('Country.name')));
			if (!empty($res[$this->alias]['name']) && !empty($res[$this->Country->alias]['name']) && $geocoder->geocode($res[$this->alias]['name'] .
				', ' . $res[$this->Country->alias]['name'])) {

				$data = $geocoder->getResult();
				//pr($data); die();
				$saveArray = array('id' => $id, 'lat' => $data['lat'], 'lng' => $data['lng'], 'country_id' => $res[$this->alias]['country_id']);

				if (!empty($data['country_province_code']) && mb_strlen($data['country_province_code']) <= 3 && preg_match('/^([A-Z])*$/', $data['country_province_code'])) {
					$saveArray['abbr'] = $data['country_province_code'];
				}

				$this->id = $id;
				if (!$this->save($saveArray, true, array('id', 'lat', 'lng', 'abbr', 'country_id'))) {
					if ($data['country_province_code'] !== 'DC') {
						echo returns($this->id);
						pr($res);
						pr($data);
						pr($saveArray);
						die(returns($this->validationErrors));
					}
				}
				return true;
			}
		} else {

			$conditions = array();
			if (!$override) {
				$conditions = array($this->alias . '.lat' => 0, $this->alias . '.lng' => 0);
			}

			$results = $this->find('all', array('conditions' => $conditions, 'contain' => array('Country.name'), 'order' => array('CountryProvince.modified' =>
				'ASC')));
			$count = 0;

			foreach ($results as $res) {
				if (!empty($res[$this->alias]['name']) && !empty($res[$this->Country->alias]['name']) && $geocoder->geocode($res[$this->alias]['name'] .
					', ' . $res[$this->Country->alias]['name'])) {

					$data = $geocoder->getResult();
					//pr($data); die();
					//pr ($geocoder->debug());
					$saveArray = array('id' => $res[$this->alias]['id'], 'country_id' => $res[$this->alias]['country_id']);
					if (isset($data['lat']) && isset($data['lng'])) {
						$saveArray = array_merge($saveArray, array('lat' => $data['lat'], 'lng' => $data['lng']));
					}

					if (!empty($data['country_province_code']) && mb_strlen($data['country_province_code']) <= 3 && preg_match('/^([A-Z])*$/', $data['country_province_code'])) {
						$saveArray['abbr'] = $data['country_province_code'];
					}

					$this->id = $res[$this->alias]['id'];
					if ($this->save($saveArray, true, array('lat', 'lng', 'abbr', 'country_id'))) {
						$count++;

						if (!empty($saveArray['abbr']) && $saveArray['abbr'] != $res[$this->alias]['abbr']) {
							$this->log('Abbr for country province \'' . $data['country_province'] . '\' changed from \'' . $res[$this->alias]['abbr'] . '\' to \'' . $saveArray['abbr'] .
								'\'', LOG_NOTICE);
						}

					} else {
						//pr($data); pr($geocoder->debug()); die();

						if ($data['country_province_code'] !== 'DC') {
							echo returns($this->id);
							pr($res);
							pr($data);
							pr($saveArray);
							die(returns($this->validationErrors));
						}
					}
					$geocoder->pause();
				}
			}

			return $count;
		}

		return false;
	}

}
