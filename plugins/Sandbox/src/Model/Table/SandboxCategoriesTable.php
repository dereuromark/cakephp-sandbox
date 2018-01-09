<?php
namespace Sandbox\Model\Table;

use Tools\Model\Table\Table;

/**
 * @mixin \Cake\ORM\Behavior\TreeBehavior
 */
class SandboxCategoriesTable extends Table {

	/**
	 * @var array
	 */
	public $actsAs = ['Tree'];

	/**
	 * @var array
	 */
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
