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
 * @extends \Cake\ORM\Table<array{Timestamp: \Cake\ORM\Behavior\TimestampBehavior, Translate: \Cake\ORM\Behavior\TranslateBehavior}, \Sandbox\Model\Entity\DemoArticle>
 * @property \Cake\ORM\Table&\Cake\ORM\Association\HasMany $DemoArticlesTranslations
 * @method \Sandbox\Model\Entity\DemoArticle patchEntity(\Sandbox\Model\Entity\DemoArticle $entity, array<mixed> $data, array<string, mixed> $options = [])
 * @method array<\Sandbox\Model\Entity\DemoArticle> patchEntities(iterable<\Sandbox\Model\Entity\DemoArticle> $entities, array<mixed> $data, array<string, mixed> $options = [])
 * @method \Sandbox\Model\Entity\DemoArticle|false save(\Sandbox\Model\Entity\DemoArticle $entity, array<string, mixed> $options = [])
 * @method \Sandbox\Model\Entity\DemoArticle saveOrFail(\Sandbox\Model\Entity\DemoArticle $entity, array<string, mixed> $options = [])
 * @method \Cake\Datasource\ResultSetInterface<int, \Sandbox\Model\Entity\DemoArticle>|false saveMany(iterable<\Sandbox\Model\Entity\DemoArticle> $entities, array<string, mixed> $options = [])
 * @method \Cake\Datasource\ResultSetInterface<int, \Sandbox\Model\Entity\DemoArticle> saveManyOrFail(iterable<\Sandbox\Model\Entity\DemoArticle> $entities, array<string, mixed> $options = [])
 * @method bool delete(\Sandbox\Model\Entity\DemoArticle $entity, array<string, mixed> $options = [])
 * @method bool deleteOrFail(\Sandbox\Model\Entity\DemoArticle $entity, array<string, mixed> $options = [])
 * @method \Cake\Datasource\ResultSetInterface<int, \Sandbox\Model\Entity\DemoArticle>|false deleteMany(iterable<\Sandbox\Model\Entity\DemoArticle> $entities, array<string, mixed> $options = [])
 * @method \Cake\Datasource\ResultSetInterface<int, \Sandbox\Model\Entity\DemoArticle> deleteManyOrFail(iterable<\Sandbox\Model\Entity\DemoArticle> $entities, array<string, mixed> $options = [])
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \Cake\ORM\Behavior\TranslateBehavior
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
