<?php

namespace App\Model\Table;

use Tools\Model\Table\Table;

/**
 * @method \App\Model\Entity\User get(mixed $primaryKey, string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\User newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\User> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\User> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, ?callable $callback = null, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 *
 * @property \App\Model\Table\RolesTable&\Cake\ORM\Association\BelongsTo $Roles
 * @method \App\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\User newEmptyEntity()
 * @method \Cake\Datasource\ResultSetInterface<\App\Model\Entity\User>|false saveMany(iterable $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\App\Model\Entity\User> saveManyOrFail(iterable $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\App\Model\Entity\User>|false deleteMany(iterable $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\App\Model\Entity\User> deleteManyOrFail(iterable $entities, array $options = [])
 */
class UsersTable extends Table {

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
			'isUnique' => [
				'rule' => 'validateUnique',
				'message' => 'Username already exists',
				'last' => true,
				'provider' => 'table',
			],
		],
		'email' => [
			'email' => [
				'rule' => ['email'],
				'message' => 'Email invalid',
				'last' => true,
			],
			'unique' => [
				'rule' => ['validateUnique'],
				'message' => 'Email already exists',
				'last' => true,
				'provider' => 'table',
			],
		],
	];

	/**
	 * @param array<string, mixed> $config
	 *
	 * @return void
	 */
	public function initialize(array $config): void {
		$this->belongsTo('Roles');

		$this->setDisplayField('username');

		$this->addBehavior('Timestamp');
	}

}
