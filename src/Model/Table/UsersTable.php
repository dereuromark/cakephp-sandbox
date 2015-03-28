<?php
namespace App\Model\Table;

use Tools\Model\Table\Table;

class UsersTable extends Table {

	public $displayField = 'username';

	public $validate = [
		'username' => [
			'notEmpty' => [
				'rule' => ['notEmpty'],
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

	public function initialize(array $config) {
		$this->belongsTo('Roles');
	}
}
