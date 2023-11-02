<?php

namespace Sandbox\Model\Table;

use Cake\Database\Type\EnumType;
use Sandbox\Model\Enum\UserStatus;
use Tools\Model\Table\Table;

class SandboxUsersTable extends Table {

	/**
	 * @var array<mixed>
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

	/**
	 * @param array<string, mixed> $config
	 *
	 * @return void
	 */
	public function initialize(array $config): void {
		$this->getSchema()->setColumnType('status', EnumType::from(UserStatus::class));

		$this->setDisplayField('username');
	}

}
