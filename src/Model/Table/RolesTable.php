<?php

namespace App\Model\Table;

use Tools\Model\Table\Table;

/**
 * @extends \Tools\Model\Table\Table<array{Timestamp: \Cake\ORM\Behavior\TimestampBehavior}, \App\Model\Entity\Role>
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\HasMany $Users
 * @method \App\Model\Entity\Role newEmptyEntity()
 * @method \App\Model\Entity\Role newEntity(array<mixed> $data, array<string, mixed> $options = [])
 * @method array<\App\Model\Entity\Role> newEntities(array<mixed> $data, array<string, mixed> $options = [])
 * @method \App\Model\Entity\Role get(mixed $primaryKey, array<string, mixed>|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \Cake\ORM\Query\SelectQuery<\App\Model\Entity\Role> find(string $type = 'all', mixed ...$args)
 * @method \App\Model\Entity\Role findOrCreate(\Cake\ORM\Query\SelectQuery<\App\Model\Entity\Role>|callable|array<string, mixed> $search, ?callable $callback = null, array<string, mixed> $options = [])
 * @method \App\Model\Entity\Role patchEntity(\App\Model\Entity\Role $entity, array<mixed> $data, array<string, mixed> $options = [])
 * @method array<\App\Model\Entity\Role> patchEntities(iterable<\App\Model\Entity\Role> $entities, array<mixed> $data, array<string, mixed> $options = [])
 * @method \App\Model\Entity\Role|false save(\App\Model\Entity\Role $entity, array<string, mixed> $options = [])
 * @method \App\Model\Entity\Role saveOrFail(\App\Model\Entity\Role $entity, array<string, mixed> $options = [])
 * @method \Cake\Datasource\ResultSetInterface<int, \App\Model\Entity\Role>|false saveMany(iterable<\App\Model\Entity\Role> $entities, array<string, mixed> $options = [])
 * @method \Cake\Datasource\ResultSetInterface<int, \App\Model\Entity\Role> saveManyOrFail(iterable<\App\Model\Entity\Role> $entities, array<string, mixed> $options = [])
 * @method bool delete(\App\Model\Entity\Role $entity, array<string, mixed> $options = [])
 * @method bool deleteOrFail(\App\Model\Entity\Role $entity, array<string, mixed> $options = [])
 * @method \Cake\Datasource\ResultSetInterface<int, \App\Model\Entity\Role>|false deleteMany(iterable<\App\Model\Entity\Role> $entities, array<string, mixed> $options = [])
 * @method \Cake\Datasource\ResultSetInterface<int, \App\Model\Entity\Role> deleteManyOrFail(iterable<\App\Model\Entity\Role> $entities, array<string, mixed> $options = [])
 * @method \App\Model\Entity\Role|array<\App\Model\Entity\Role> loadInto(\App\Model\Entity\Role|array<\App\Model\Entity\Role> $entities, array<mixed> $contain)
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
