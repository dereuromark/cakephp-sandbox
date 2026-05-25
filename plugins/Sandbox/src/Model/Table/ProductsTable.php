<?php
declare(strict_types=1);

namespace Sandbox\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Sandbox\Model\Filter\ProductsCollection;

/**
 * SandboxProducts Model
 *
 * @extends \Cake\ORM\Table<array{Search: \Search\Model\Behavior\SearchBehavior, Timestamp: \Cake\ORM\Behavior\TimestampBehavior}, \Sandbox\Model\Entity\Product>
 * @method \Sandbox\Model\Entity\Product patchEntity(\Sandbox\Model\Entity\Product $entity, array $data, array $options = [])
 * @method array<\Sandbox\Model\Entity\Product> patchEntities(iterable<\Sandbox\Model\Entity\Product> $entities, array $data, array $options = [])
 * @method \Sandbox\Model\Entity\Product|false save(\Sandbox\Model\Entity\Product $entity, array $options = [])
 * @method \Sandbox\Model\Entity\Product saveOrFail(\Sandbox\Model\Entity\Product $entity, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\Product>|false saveMany(iterable<\Sandbox\Model\Entity\Product> $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\Product> saveManyOrFail(iterable<\Sandbox\Model\Entity\Product> $entities, array $options = [])
 * @method bool delete(\Sandbox\Model\Entity\Product $entity, array $options = [])
 * @method bool deleteOrFail(\Sandbox\Model\Entity\Product $entity, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\Product>|false deleteMany(iterable<\Sandbox\Model\Entity\Product> $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\Product> deleteManyOrFail(iterable<\Sandbox\Model\Entity\Product> $entities, array $options = [])
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
		$this->addBehavior('Search.Search', [
			'collectionClass' => ProductsCollection::class,
		]);
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

}
