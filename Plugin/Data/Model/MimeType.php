<?php
App::uses('DataAppModel', 'Data.Model');
App::uses('File', 'Utility');

class MimeType extends DataAppModel {

	public $order = array('MimeType.modified' => 'DESC');

	public $validate = array(
		'name' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'valErrMandatoryField',
			),
		),
		'ext' => array(
			'isUnique' => array(
				'rule' => 'isUnique',
				'message' => 'Already exists',
			),
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'valErrMandatoryField',
				'allowEmpty' => false,
				//'required' => true
			),
		),
		'type' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'valErrMandatoryField',
			),
		),
		'active' => array('numeric'),
		'mime_type_image_id' => array('numeric'),
	);

	public $belongsTo = array(
		'MimeTypeImage' => array(
			'className' => 'Data.MimeTypeImage',
			'foreignKey' => 'mime_type_image_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);

	public function beforeSave($options = array()) {
		parent::beforeSave($options);
		if (isset($this->data[$this->alias]['ext'])) {
			$this->data[$this->alias]['ext'] = mb_strtolower($this->data[$this->alias]['ext']);
		}
		if (isset($this->data[$this->alias]['name'])) {
			$this->data[$this->alias]['name'] = ucwords($this->data[$this->alias]['name']);
		}

		return true;
	}

	public function afterSave($created, $options = array()) {
		parent::afterSave($created, $options);

		$this->cleanUp();
	}

	public function afterDelete() {
		parent::afterDelete();

		$this->cleanUp();
	}

	public function cleanUp() {
		$Handle = new File(FILES . 'mime_types.txt');
		$Handle->delete();
	}

	public function mimeTypes($inactiveOnes = false) {
		$options = array('conditions' => array($this->alias . '.ext' => $ext));
		if ($inactiveOnes !== true) {
			$options['conditions'][$this->alias . '.active'] = 1;
		}
		return $this->find('first', $options);
	}

	public function mimeTypeExists($ext = null) {
		if (empty($ext)) {
			return array();
		}
		return $this->find('first', array('conditions' => array($this->alias . '.ext' => $ext)));
	}

	/**
	 * Push this type up in the "usage ranking" (sort)
	 * could be done on every upload/download = automagic sort by priority
	 *
	 * @param string $ext
	 * @return void
	 */
	public function push($ext = null) {
		$type = $this->mimeTypeExists($ext);
		if (!empty($type)) {
			$this->id = $type[$this->alias]['id'];
			return $this->saveField('sort', $type[$this->alias]['sort'] + 1);
		}
		# insert this new extension
		$data = array('ext' => $ext, 'name' => 'auto-added', 'sort' => 1);
		$this->create();
		if (!$this->save($data)) {
			$this->log('problem with pushing new mimeType');
			return false;
		}
		# notify admin
		App::uses('EmailLib', 'Tools.Lib');
		App::import('Controller', 'Data.MimeTypes');
		$this->Email = new EmailLib();
		$this->Email->to(Configure::read('Config.admin_email'), Configure::read('Config.admin_emailname'));
		$this->Email->replyTo(Configure::read('Config.admin_email'), Configure::read('Config.admin_emailname'));

		//$this->Email->from(Configure::read('Config.admin_email'), Configure::read('Config.admin_emailname'));

		$this->Email->subject(Configure::read('Config.page_name') . ' - ' . __('MimeType'));
		$this->Email->template('simple_email');

		$text = 'MimeType hinzugefügt: ' . $ext . '';
		$this->Email->viewVars(compact('text'));

		if (!$this->Email->send()) {
			$this->log('problem with mailing to admin after pushing mimeType');
		}

		return true;
	}

}
