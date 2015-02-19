<?php
namespace App\Model\Table;

use Tools\Model\Table\Table;

class UsersTable extends Table {

	public $displayField = 'username';

	public $validate = array(
		'username' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Mandatory',
				'last' => true
			),
			'isUnique' => array(
				'rule' => 'validateUnique',
				'message' => 'Username already exists',
				'last' => true,
				'provider' => 'table'
			),
		),
		'email' => array(
			'email' => array(
				'rule' => array('email'),
				'message' => 'Email invalid',
				'last' => true
			),
			'unique' => array(
				'rule' => array('validateUnique'),
				'message' => 'Email already exists',
				'last' => true,
				'provider' => 'table'
			),
		),
	);

	public function initialize(array $config) {
		$this->belongsTo('Roles');
	}
}
