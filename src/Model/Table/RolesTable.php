<?php

namespace App\Model\Table;

use Tools\Model\Table\Table;

/**
 * @method \App\Model\Entity\Role get($primaryKey, $options = [])
 * @method \App\Model\Entity\Role newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Role> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Role|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Role saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Role patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Role> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Role findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Role newEmptyEntity()
 * @method \Cake\Datasource\ResultSetInterface<\App\Model\Entity\Role>|false saveMany(iterable $entities, $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\App\Model\Entity\Role> saveManyOrFail(iterable $entities, $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\App\Model\Entity\Role>|false deleteMany(iterable $entities, $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\App\Model\Entity\Role> deleteManyOrFail(iterable $entities, $options = [])
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\HasMany $Users
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class RolesTable extends Table {

	/**
	 * @param array $config
	 *
	 * @return void
	 */
	public function initialize(array $config): void {
		$this->hasMany('Users');

		$this->addBehavior('Timestamp');
	}

}
