<?php
App::uses('DataAppModel', 'Data.Model');

class District extends DataAppModel {

	public $actsAs = array('Tools.Geocoder' => array(
		'min_accuracy' => 3, 'address' => array('address'), 'before' => 'save', 'real' => false, 'required' => false
	), 'Data.Slugged' => array('mode' => 'ascii', 'case' => 'low'));

	public $order = array('District.name' => 'ASC');

	public $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'valErrMandatoryField',
			),
		),
		'city_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'valErrMandatoryField',
			),
		),
	);

	public $belongsTo = array(
		'City' => array(
			'className' => 'Data.City',
			'foreignKey' => 'city_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	/**
	 * District::beforeValidate()
	 *
	 * @param array $options
	 * @return boolean Success
	 */
	public function beforeValidate($options = array()) {
		parent::beforeValidate($options);

		if (!empty($this->data[$this->alias]['name']) && !empty($this->data[$this->alias]['city_id'])) {
			$city = $this->City->field('name', array('id' => $this->data[$this->alias]['city_id']));
			$this->data[$this->alias]['address'] = $this->data[$this->alias]['name'] . ', ' . $city;
		}

		return true;
	}

	/**
	 * For start page
	 *
	 * @return array
	 */
	public function getDistrictsByCity($citySlug, $type = 'all') {
		$options = array(
			'contain' => array('City.slug'),
			'conditions' => array(
				//$this->alias.'.lat <>' => 0,
				//$this->alias.'.lng <>' => 0,
				$this->City->alias . '.slug' => $citySlug,
			),
			'fields' => array($this->alias . '.slug', $this->alias . '.name'),
		);
		return $this->find($type, $options);
	}

	/**
	 * District::getIdBySlug()
	 *
	 * @param string $slug
	 * @param array $customOptions
	 * @return array
	 */
	public function getIdBySlug($slug, $customOptions = array()) {
		$options = array(
			'conditions' => array(
				$this->alias . '.slug' => $slug,
			)
		);
		if (!empty($customOptions)) {
			$options = array_merge($options, $customOptions);
		}
		return $this->find('first', $options);
	}

}
