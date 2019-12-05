<?php

namespace Sandbox\Model\Table;

use Tools\Model\Table\Table;

class SandboxUsersTable extends Table {

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
				'last' => true,
			],
		],
		'email' => [
			'email' => [
				'rule' => ['email'],
				'message' => 'Email invalid',
				'last' => true,
			],
		],
	];

}
