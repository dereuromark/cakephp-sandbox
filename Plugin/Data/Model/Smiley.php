<?php
App::uses('DataAppModel', 'Data.Model');

class Smiley extends DataAppModel {

	public $order = array('Smiley.is_base' => 'DESC', 'Smiley.sort' => 'DESC');

	public $validate = array(
		'smiley_cat_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'valErrMandatoryField'
			),
		),
		'smiley_path' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'valErrMandatoryField'
			),
		),
		'title' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'valErrMandatoryField',
			),
		),
		'prim_code' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'valErrMandatoryField',
				'last' => true,
			),
			'uniqueCode' => array(
				'rule' => array('validateUniqueCode'),
				'message' => 'This code already exists'
			),
		),
		'sec_code' => array(
			'uniqueCode' => array(
				'rule' => array('validateUniqueCode'),
				'message' => 'This code already exists'
			),
		),
		'is_base' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				'message' => 'valErrMandatoryField'
			),
		),
		'sort' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'valErrMandatoryField'
			),
		),
		'active' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				'message' => 'valErrMandatoryField'
			),
		),
	);

	public $belongsTo = array(
		/*
		'SmileyCat' => array(
			'className' => 'SmileyCat',
			'foreignKey' => 'smiley_cat_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
		*/
	);

	/**
	 * Export list of smileys for textarea fields etc
	 * note: cache it!
	 * category not yet supported
	 */
	public function getList($category = null) {
		$conditions = array($this->alias . '.active' => 1);
		if (!empty($category)) {
			$conditions['category_id'] = $category;
		}

		$res = $this->find('all', array(
			'fields' => array('prim_code', 'sec_code', 'smiley_path', 'title', 'is_base'),
			'conditions' => $conditions
		));
		return $res;
	}

	/**
	 * Export list of smileys for textarea fields etc
	 * flattet result:
	 * - code, image, path, url, title, base
	 */
	public function export($category = null) {
		$smileys = $this->getList($category);
		$res = array();

		$path = '/Data/img/smileys/default/';
		foreach ($smileys as $smiley) {
			if (!empty($smiley[$this->alias]['prim_code'])) {
				$res[] = array(
					'code' => $smiley[$this->alias]['prim_code'],
					'path' => App::pluginPath('Data') . 'webroot' . DS . 'img' . DS . 'smileys' . DS . 'default' . DS . $smiley[$this->alias]['smiley_path'],
					'url' => $path . $smiley[$this->alias]['smiley_path'],
					'title' => $smiley[$this->alias]['title'],
					'base' => $smiley[$this->alias]['is_base']
				);
			}
			if (!empty($smiley[$this->alias]['sec_code'])) {
				$res[] = array(
					'code' => $smiley[$this->alias]['sec_code'],
					'path' => App::pluginPath('Data') . 'webroot' . DS . 'img' . DS . 'smileys' . DS . 'default' . DS . $smiley[$this->alias]['smiley_path'],
					'url' => $path . $smiley[$this->alias]['smiley_path'],
					'title' => $smiley[$this->alias]['title'],
					'base' => $smiley[$this->alias]['is_base']
				);
			}
		}
		return $res;
	}

	public function validateUniqueCode($code, $allowEmpty = true) {
		$code = array_shift($code);
		if (empty($code)) {
			return true;
		}
		if ($this->find('first', array(
			'fields' => array('id'),
			'conditions' => array('OR' => array(array($this->alias . '.prim_code' => $code, array($this->alias . '.sec_code' => $code))))
		))) {
			return false;
		}
		return true;
	}

}
