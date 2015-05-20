<?php
namespace Sandbox\Model\Table;

use Tools\Model\Table\Table;

class SandboxCategoriesTable extends Table {

	public $actsAs = ['Tree'];

	public $validate = [
		'name' => [
			'notEmpty' => [
				'rule' => ['notBlank'],
				'message' => 'Mandatory',
				'last' => true
			]
		],
	];

}
