<?php

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\Validation\Validator;
use Tools\Model\Table\Table;

/**
 * @method \App\Model\Entity\User get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\User newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\User> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\User> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate(\Cake\ORM\Query\SelectQuery|callable|array $search, ?callable $callback = null, array $options = [])
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
 * @extends \Tools\Model\Table\Table<array{Timestamp: \Cake\ORM\Behavior\TimestampBehavior}>
 */
class UsersTable extends Table {

	/**
	 * @param array<string, mixed> $config
	 *
	 * @return void
	 */
	public function initialize(array $config): void {
		parent::initialize($config);

		$this->belongsTo('Roles');

		$this->setDisplayField('username');

		$this->addBehavior('Timestamp');
	}

	/**
	 * @param \Cake\Validation\Validator $validator
	 *
	 * @return \Cake\Validation\Validator
	 */
	public function validationDefault(Validator $validator): Validator {
		$validator
			->requirePresence('username', 'create')
			->notBlank('username', 'Mandatory')
			->add('username', 'unique', [
				'rule' => 'validateUnique',
				'provider' => 'table',
				'message' => 'Username already exists',
			]);

		$validator
			->requirePresence('email', 'create')
			->email('email', false, 'Email invalid')
			->add('email', 'unique', [
				'rule' => 'validateUnique',
				'provider' => 'table',
				'message' => 'Email already exists',
			]);

		return $validator;
	}

	/**
	 * Custom finder for authentication that allows login by username OR email.
	 * The Password identifier will call this finder and pass the login value
	 * via the 'login' key (matching our field configuration).
	 *
	 * @param \Cake\ORM\Query\SelectQuery $query
	 * @param array<string, mixed> $options
	 * @return \Cake\ORM\Query\SelectQuery
	 */
	public function findAuth(SelectQuery $query, array $options): SelectQuery {
		// Check for 'login' field (our custom credential field)
		if (isset($options['login'])) {
			$login = $options['login'];
			$query->where([
				'OR' => [
					$this->aliasField('username') => $login,
					$this->aliasField('email') => $login,
				],
			]);
		}

		return $query;
	}

}
