<?php
declare(strict_types=1);

namespace Sandbox\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DemoArticles Model
 *
 * Demonstrates the Translate Behavior with Shadow Table strategy.
 *
 * @method \Sandbox\Model\Entity\DemoArticle newEmptyEntity()
 * @method \Sandbox\Model\Entity\DemoArticle newEntity(array $data, array $options = [])
 * @method array<\Sandbox\Model\Entity\DemoArticle> newEntities(array $data, array $options = [])
 * @method \Sandbox\Model\Entity\DemoArticle get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \Sandbox\Model\Entity\DemoArticle findOrCreate(\Cake\ORM\Query\SelectQuery|callable|array $search, ?callable $callback = null, array $options = [])
 * @method \Sandbox\Model\Entity\DemoArticle patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\Sandbox\Model\Entity\DemoArticle> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \Sandbox\Model\Entity\DemoArticle|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \Sandbox\Model\Entity\DemoArticle saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\DemoArticle>|false saveMany(iterable $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\DemoArticle> saveManyOrFail(iterable $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\DemoArticle>|false deleteMany(iterable $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\DemoArticle> deleteManyOrFail(iterable $entities, array $options = [])
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \Cake\ORM\Behavior\TranslateBehavior
 * @extends \Cake\ORM\Table<array{Timestamp: \Cake\ORM\Behavior\TimestampBehavior, Translate: \Cake\ORM\Behavior\TranslateBehavior}>
 * @property \Cake\ORM\Table&\Cake\ORM\Association\HasMany $DemoArticlesTranslations
 */
class DemoArticlesTable extends Table {

	/**
	 * Initialize method
	 *
	 * @param array<string, mixed> $config The configuration for the Table.
	 * @return void
	 */
	public function initialize(array $config): void {
		parent::initialize($config);

		$this->setTable('demo_articles');
		$this->setDisplayField('title');
		$this->setPrimaryKey('id');

		$this->addBehavior('Timestamp');

		// Configure Translate Behavior with shadow table strategy
		// Translations are stored in demo_articles_translations table
		// Shadow table has the same structure as main table plus locale column
		$this->addBehavior('Translate', [
			'fields' => ['title', 'content'],
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
			->maxLength('title', 255)
			->requirePresence('title', 'create')
			->notEmptyString('title');

		$validator
			->scalar('content')
			->requirePresence('content', 'create')
			->notEmptyString('content');

		$validator
			->scalar('status')
			->maxLength('status', 255)
			->requirePresence('status', 'create')
			->notEmptyString('status');

		return $validator;
	}

}
