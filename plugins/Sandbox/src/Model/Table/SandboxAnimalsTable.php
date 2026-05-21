<?php

namespace Sandbox\Model\Table;

use Cake\Datasource\EntityInterface;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;
use Tools\Model\Table\Table;

/**
 * Animals Model
 *
 * @extends \Tools\Model\Table\Table<array{}, \Sandbox\Model\Entity\SandboxAnimal>
 * @method \Sandbox\Model\Entity\SandboxAnimal newEmptyEntity()
 * @method \Sandbox\Model\Entity\SandboxAnimal newEntity(array $data, array $options = [])
 * @method array<\Sandbox\Model\Entity\SandboxAnimal> newEntities(array $data, array $options = [])
 * @method \Sandbox\Model\Entity\SandboxAnimal get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \Cake\ORM\Query\SelectQuery<\Sandbox\Model\Entity\SandboxAnimal> find(string $type = 'all', mixed ...$args)
 * @method \Sandbox\Model\Entity\SandboxAnimal findOrCreate(\Cake\ORM\Query\SelectQuery|callable|array $search, ?callable $callback = null, array $options = [])
 * @method \Sandbox\Model\Entity\SandboxAnimal patchEntity(\Sandbox\Model\Entity\SandboxAnimal $entity, array $data, array $options = [])
 * @method array<\Sandbox\Model\Entity\SandboxAnimal> patchEntities(iterable<\Sandbox\Model\Entity\SandboxAnimal> $entities, array $data, array $options = [])
 * @method \Sandbox\Model\Entity\SandboxAnimal|false save(\Sandbox\Model\Entity\SandboxAnimal $entity, array $options = [])
 * @method \Sandbox\Model\Entity\SandboxAnimal saveOrFail(\Sandbox\Model\Entity\SandboxAnimal $entity, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\SandboxAnimal>|false saveMany(iterable<\Sandbox\Model\Entity\SandboxAnimal> $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\SandboxAnimal> saveManyOrFail(iterable<\Sandbox\Model\Entity\SandboxAnimal> $entities, array $options = [])
 * @method bool delete(\Sandbox\Model\Entity\SandboxAnimal $entity, array $options = [])
 * @method bool deleteOrFail(\Sandbox\Model\Entity\SandboxAnimal $entity, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\SandboxAnimal>|false deleteMany(iterable<\Sandbox\Model\Entity\SandboxAnimal> $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\SandboxAnimal> deleteManyOrFail(iterable<\Sandbox\Model\Entity\SandboxAnimal> $entities, array $options = [])
 * @method \Sandbox\Model\Entity\SandboxAnimal|array<\Sandbox\Model\Entity\SandboxAnimal> loadInto(\Sandbox\Model\Entity\SandboxAnimal|array<\Sandbox\Model\Entity\SandboxAnimal> $entities, array $contain)
 */
class SandboxAnimalsTable extends Table {

	/**
	 * @var array<int|string, mixed>
	 */
	protected array $order = ['name' => 'ASC'];

	/**
	 * @param \Cake\Validation\Validator $validator
	 *
	 * @return \Cake\Validation\Validator
	 */
	public function validationDefault(Validator $validator): Validator {
		$validator
			->add('name', 'alphanumeric', [
				'rule' => 'alphanumeric',
				'message' => __('You need to provide a name, only alphanumeric chars are allowed.'),
				//'provider' => 'table',
				'requirePresence' => true,
				'allowEmpty' => false,
				'last' => true,
			])
			->add('name', [
				'unique' => ['rule' => 'validateUnique', 'provider' => 'table', 'message' => 'This animal already exists!'],
			])
			->add('confirm', 'notEmpty', [
				'rule' => function ($value, $context) {
					return !empty($value);
				},
				'message' => __('Please select checkbox to continue.'),
				//'provider' => 'table',
				'requirePresence' => true,
				'allowEmpty' => false,
				'last' => true,
			]);

		return $validator;
	}

	/**
	 * @param \Cake\ORM\RulesChecker $rules
	 *
	 * @return \Cake\ORM\RulesChecker
	 */
	public function buildRules(RulesChecker $rules): RulesChecker {
		// Add a rule that is applied for create and update operations
		$rules->add(function (EntityInterface $entity, $options) {
			$name = $entity->get('name');
			if ($name !== 'Mouse' && $name !== 'Cat') {
				return false;
			}

			return true;
		});

		return $rules;
	}

}
