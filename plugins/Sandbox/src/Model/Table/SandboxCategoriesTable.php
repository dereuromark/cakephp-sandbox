<?php

namespace Sandbox\Model\Table;

use Tools\Model\Table\Table;

/**
 * @mixin \Cake\ORM\Behavior\TreeBehavior
 * @method \Sandbox\Model\Entity\SandboxCategory get($primaryKey, $options = [])
 * @method \Sandbox\Model\Entity\SandboxCategory newEntity(array $data, array $options = [])
 * @method array<\Sandbox\Model\Entity\SandboxCategory> newEntities(array $data, array $options = [])
 * @method \Sandbox\Model\Entity\SandboxCategory|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Sandbox\Model\Entity\SandboxCategory saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Sandbox\Model\Entity\SandboxCategory patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\Sandbox\Model\Entity\SandboxCategory> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \Sandbox\Model\Entity\SandboxCategory findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \Sandbox\Model\Entity\SandboxCategory newEmptyEntity()
 * @method iterable<\Sandbox\Model\Entity\SandboxCategory>|false saveMany(iterable $entities, $options = [])
 * @method iterable<\Sandbox\Model\Entity\SandboxCategory> saveManyOrFail(iterable $entities, $options = [])
 * @method iterable<\Sandbox\Model\Entity\SandboxCategory>|false deleteMany(iterable $entities, $options = [])
 * @method iterable<\Sandbox\Model\Entity\SandboxCategory> deleteManyOrFail(iterable $entities, $options = [])
 */
class SandboxCategoriesTable extends Table {

	/**
	 * @var array<mixed>
	 */
	public $actsAs = ['Tree'];

	/**
	 * @var array<mixed>
	 */
	public $validate = [
		'name' => [
			'notEmpty' => [
				'rule' => ['notBlank'],
				'message' => 'Mandatory',
				'last' => true,
			],
		],
	];

}
