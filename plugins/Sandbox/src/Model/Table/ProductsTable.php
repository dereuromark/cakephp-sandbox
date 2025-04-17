<?php
declare(strict_types=1);

namespace Sandbox\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SandboxProducts Model
 *
 * @method \Sandbox\Model\Entity\Product newEmptyEntity()
 * @method \Sandbox\Model\Entity\Product newEntity(array $data, array $options = [])
 * @method array<\Sandbox\Model\Entity\Product> newEntities(array $data, array $options = [])
 * @method \Sandbox\Model\Entity\Product get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \Sandbox\Model\Entity\Product findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \Sandbox\Model\Entity\Product patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\Sandbox\Model\Entity\Product> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \Sandbox\Model\Entity\Product|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \Sandbox\Model\Entity\Product saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\Sandbox\Model\Entity\Product>|\Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\Product>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\Sandbox\Model\Entity\Product>|\Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\Product> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\Sandbox\Model\Entity\Product>|\Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\Product>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\Sandbox\Model\Entity\Product>|\Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\Product> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \Search\Model\Behavior\SearchBehavior
 */
class ProductsTable extends Table {

	/**
	 * Initialize method
	 *
	 * @param array<string, mixed> $config The configuration for the Table.
	 * @return void
	 */
	public function initialize(array $config): void {
		parent::initialize($config);

		$this->setTable('sandbox_products');
		$this->setDisplayField('title');
		$this->setPrimaryKey('id');

		$this->addBehavior('Timestamp');
		$this->addBehavior('Search.Search');
	}

	/**
	 * Default validation rules.
	 *
	 * @param \Cake\Validation\Validator $validator Validator instance.
	 * @return \Cake\Validation\Validator
	 */
	public function validationDefault(Validator $validator): Validator {
		$validator
			->scalar('title')
			->maxLength('title', 100)
			->requirePresence('title', 'create')
			->notEmptyString('title');

		$validator
			->decimal('price')
			->requirePresence('price', 'create')
			->notEmptyString('price');

		return $validator;
	}

	/**
	 * @return \Search\Manager
	 */
	public function searchManager() {
		$searchManager = $this->behaviors()->Search->searchManager();
		$searchManager
			->like('title', ['before' => true, 'after' => true])
			->callback('price_max', [
				'callback' => function (SelectQuery $query, array $args, $filter) {
					return false;
				},
			])
			->callback('price_min', [
				'callback' => function (SelectQuery $query, array $args, $filter) {
					$min = (int)$args['price_min'];
					$max = (int)($args['price_max'] ?? null);
					if (!$min && !$max || $max < $min) {
						return false;
					}

					$query->where(['price >=' => $min, 'price <=' => $max]);

					return true;
				},
			]);

		return $searchManager;
	}

}
