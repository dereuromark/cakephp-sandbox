<?php

namespace App\Model\Table;

use Tools\Model\Table\Table;

/**
 * @extends \Tools\Model\Table\Table<array{Timestamp: \Cake\ORM\Behavior\TimestampBehavior}>
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\HasMany $Users
 * @method \App\Model\Entity\Role get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Role newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Role> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Role|false save(\App\Model\Entity\Role $entity, array $options = [])
 * @method \App\Model\Entity\Role saveOrFail(\App\Model\Entity\Role $entity, array $options = [])
 * @method \App\Model\Entity\Role patchEntity(\App\Model\Entity\Role $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Role> patchEntities(iterable<\App\Model\Entity\Role> $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Role findOrCreate(\Cake\ORM\Query\SelectQuery|callable|array $search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Role newEmptyEntity()
 * @method \Cake\Datasource\ResultSetInterface<\App\Model\Entity\Role>|false saveMany(iterable<\App\Model\Entity\Role> $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\App\Model\Entity\Role> saveManyOrFail(iterable<\App\Model\Entity\Role> $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\App\Model\Entity\Role>|false deleteMany(iterable<\App\Model\Entity\Role> $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\App\Model\Entity\Role> deleteManyOrFail(iterable<\App\Model\Entity\Role> $entities, array $options = [])
 * @method \Cake\ORM\Query\SelectQuery<\App\Model\Entity\Role> find(string $type = 'all', mixed ...$args)
 * @method bool delete(\App\Model\Entity\Role $entity, array $options = [])
 * @method bool deleteOrFail(\App\Model\Entity\Role $entity, array $options = [])
 * @method \App\Model\Entity\Role|array<\App\Model\Entity\Role> loadInto(\App\Model\Entity\Role|array<\App\Model\Entity\Role> $entities, array $contain)
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class RolesTable extends Table {

	/**
	 * @param array<string, mixed> $config
	 *
	 * @return void
	 */
	public function initialize(array $config): void {
		$this->hasMany('Users');

		$this->addBehavior('Timestamp');
	}

}
