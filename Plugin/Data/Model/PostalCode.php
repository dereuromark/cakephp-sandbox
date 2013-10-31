<?php
App::uses('DataAppModel', 'Data.Model');
class PostalCode extends DataAppModel {

	public $displayField = 'code';

	public $order = array('PostalCode.code' => 'ASC');

	public $actsAs = array('Tools.Geocoder' => array('min_accuracy' => 2, 'address' => array('code', 'country_name'), 'formatted_address' => 'official_address', 'real' => false, 'before' => 'validate', 'allow_inconclusive' => true));

	public $validate = array(
		'code' => array('notempty'),
		'official_address' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'valErrMandatoryField',
				'last' => true
			),
			'validateUnique' => array(
				'rule' => array('validateUnique', array('country_id', 'code')),
				'message' => 'valErrRecordNameExists',
				'last' => true,
			),
		),
	);

	public $filterArgs = array(
		'code' => array('type' => 'like', 'before' => false, 'after' => false),
		'country' => array('type' => 'value'),
	);

	public function findNearest($lat, $lng, $type = 'all', $options = array()) {
		$this->virtualFields = array('distance' => $this->_latLng($lat, $lng));
		$options['conditions']['OR'] = array($this->alias . '.lat<>0', $this->alias . '.lng<>0');
		$options['order'] = array('distance' => 'ASC');

		return $this->find($type, $options);
	}

	public function _latLng($lat, $lng) {
		return '6371.04 * ACOS( COS( PI()/2 - RADIANS(90 - ' . $this->alias . '.lat)) * ' .
			'COS( PI()/2 - RADIANS(90 - ' . $lat . ')) * ' .
			'COS( RADIANS(' . $this->alias . '.lng) - RADIANS(' . $lng . ')) + ' .
			'SIN( PI()/2 - RADIANS(90 - ' . $this->alias . '.lat)) * ' .
			'SIN( PI()/2 - RADIANS(90 - ' . $lat . '))) ';
	}

	public function searchLocation($code, $countryId = null, $options = array()) {
		if (!empty($options['exact'])) {
			if (!empty($options['term'])) {
				$term = sprintf($options['term'], $code);
			} else {
				$term = $code . '%';
			}
			$search = array('PostalCode.code LIKE' => "$term");
		} else {
			$search = array('PostalCode.code' => $code);
		}

		if ($countryId) {
			$search['PostalCode.country_id'] = (int)$country;
		}

		$options = array(
			//'fields' => array('Company.*'),
			'conditions' => $search,
			'limit' => 15,
			//'order'=>'Company.name',
			'contain' => array()
		);
		return $this->find('all', $options);
	}

	/**
	 * Postal codes per country
	 */
	public function stats() {
		$res = array();

		$list = $this->find('all', array('fields' => array('COUNT(*) as count', 'country_id'), 'group' => 'country_id'));

		foreach ($list as $x) {
			$res[$x[$this->alias]['country_id']] = $x[0]['count'];
		}

		return $res;
	}

}
