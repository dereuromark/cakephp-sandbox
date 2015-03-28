<?php
namespace Sandbox\Model\Table;

use Tools\Model\Table\Table;

class SandboxUsersTable extends Table {

	public $displayField = 'username';

	public $validate = [
		'username' => [
			'notEmpty' => [
				'rule' => ['notEmpty'],
				'message' => 'Mandatory',
				'last' => true
			]
		],
		'email' => [
			'email' => [
				'rule' => ['email'],
				'message' => 'Email invalid',
				'last' => true
			]
		],
	];

}
