<?php
App::uses('AppModel', 'Model');

class User extends AppModel {

	public $displayField = 'username';

	public $validate = array(
		'username' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Mandatory',
				'last' => true
			),
			'isUnique' => array(
				'rule' => 'isUnique',
				'message' => 'Username already exists',
				'last' => true
			),
		),
		'email' => array(
			'email' => array(
				'rule' => array('email'),
				'message' => 'Email invalid',
				'last' => true
			),
			'unique' => array(
				'rule' => array('isUnique'),
				'message' => 'Email already exists',
				'last' => true
			),
		),
	);

}
