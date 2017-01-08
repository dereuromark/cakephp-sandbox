<?php
namespace App\Model\Table;

use Tools\Model\Table\Table;

class UsersTable extends Table {

	/**
	 * @var string
	 */
	public $displayField = 'username';

	/**
	 * @var array
	 */
	public $validate = [
		'username' => [
			'notEmpty' => [
				'rule' => ['notBlank'],
				'message' => 'Mandatory',
				'last' => true
			],
			'isUnique' => [
				'rule' => 'validateUnique',
				'message' => 'Username already exists',
				'last' => true,
				'provider' => 'table'
			],
		],
		'email' => [
			'email' => [
				'rule' => ['email'],
				'message' => 'Email invalid',
				'last' => true
			],
			'unique' => [
				'rule' => ['validateUnique'],
				'message' => 'Email already exists',
				'last' => true,
				'provider' => 'table'
			],
		],
	];

	/***
	 * @param array $config
	 *
	 * @return void
	 */
	public function initialize(array $config) {
		$this->belongsTo('Roles');

		$this->addBehavior('Timestamp');
	}

}
