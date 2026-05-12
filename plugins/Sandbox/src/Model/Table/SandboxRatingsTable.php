<?php

namespace Sandbox\Model\Table;

use Ratings\Model\Table\RatingsTable;

/**
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @method \Sandbox\Model\Entity\SandboxRating newEmptyEntity()
 * @method \Sandbox\Model\Entity\SandboxRating newEntity(array $data, array $options = [])
 * @method array<\Sandbox\Model\Entity\SandboxRating> newEntities(array $data, array $options = [])
 * @method \Sandbox\Model\Entity\SandboxRating get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \Cake\ORM\Query\SelectQuery<\Sandbox\Model\Entity\SandboxRating> find(string $type = 'all', mixed ...$args)
 * @method \Sandbox\Model\Entity\SandboxRating findOrCreate(\Cake\ORM\Query\SelectQuery|callable|array $search, ?callable $callback = null, array $options = [])
 * @method \Sandbox\Model\Entity\SandboxRating patchEntity(\Sandbox\Model\Entity\SandboxRating $entity, array $data, array $options = [])
 * @method array<\Sandbox\Model\Entity\SandboxRating> patchEntities(iterable<\Sandbox\Model\Entity\SandboxRating> $entities, array $data, array $options = [])
 * @method \Sandbox\Model\Entity\SandboxRating|false save(\Sandbox\Model\Entity\SandboxRating $entity, array $options = [])
 * @method \Sandbox\Model\Entity\SandboxRating saveOrFail(\Sandbox\Model\Entity\SandboxRating $entity, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\SandboxRating>|false saveMany(iterable<\Sandbox\Model\Entity\SandboxRating> $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\SandboxRating> saveManyOrFail(iterable<\Sandbox\Model\Entity\SandboxRating> $entities, array $options = [])
 * @method bool delete(\Sandbox\Model\Entity\SandboxRating $entity, array $options = [])
 * @method bool deleteOrFail(\Sandbox\Model\Entity\SandboxRating $entity, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\SandboxRating>|false deleteMany(iterable<\Sandbox\Model\Entity\SandboxRating> $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\SandboxRating> deleteManyOrFail(iterable<\Sandbox\Model\Entity\SandboxRating> $entities, array $options = [])
 * @method \Sandbox\Model\Entity\SandboxRating|array<\Sandbox\Model\Entity\SandboxRating> loadInto(\Sandbox\Model\Entity\SandboxRating|array<\Sandbox\Model\Entity\SandboxRating> $entities, array $contain)
 */
class SandboxRatingsTable extends RatingsTable {
}
