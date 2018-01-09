<?php
namespace Sandbox\Model\Table;

use Tools\Model\Table\Table;

/**
 * @mixin \Ratings\Model\Behavior\RatableBehavior
 */
class SandboxPostsTable extends Table {

	/**
	 * @var array
	 */
	public $validate = [
		'title' => [
			'notEmpty' => [
				'rule' => ['notBlank'],
				'message' => 'Mandatory',
				'last' => true
			]
		],
		'content' => [
			'notEmpty' => [
				'rule' => ['notBlank'],
				'message' => 'Mandatory',
				'last' => true
			]
		],
	];

}
