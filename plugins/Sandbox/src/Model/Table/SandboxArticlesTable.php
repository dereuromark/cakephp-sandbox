<?php
declare(strict_types=1);

namespace Sandbox\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SandboxArticles Model
 *
 * @extends \Cake\ORM\Table<array{AuditLog: \AuditStash\Model\Behavior\AuditLogBehavior, Timestamp: \Cake\ORM\Behavior\TimestampBehavior}>
 * @method \Sandbox\Model\Entity\SandboxArticle newEmptyEntity()
 * @method \Sandbox\Model\Entity\SandboxArticle newEntity(array $data, array $options = [])
 * @method array<\Sandbox\Model\Entity\SandboxArticle> newEntities(array $data, array $options = [])
 * @method \Sandbox\Model\Entity\SandboxArticle get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \Cake\ORM\Query\SelectQuery<\Sandbox\Model\Entity\SandboxArticle> find(string $type = 'all', mixed ...$args)
 * @method \Sandbox\Model\Entity\SandboxArticle findOrCreate(\Cake\ORM\Query\SelectQuery|callable|array $search, ?callable $callback = null, array $options = [])
 * @method \Sandbox\Model\Entity\SandboxArticle patchEntity(\Sandbox\Model\Entity\SandboxArticle $entity, array $data, array $options = [])
 * @method array<\Sandbox\Model\Entity\SandboxArticle> patchEntities(iterable<\Sandbox\Model\Entity\SandboxArticle> $entities, array $data, array $options = [])
 * @method \Sandbox\Model\Entity\SandboxArticle|false save(\Sandbox\Model\Entity\SandboxArticle $entity, array $options = [])
 * @method \Sandbox\Model\Entity\SandboxArticle saveOrFail(\Sandbox\Model\Entity\SandboxArticle $entity, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\SandboxArticle>|false saveMany(iterable<\Sandbox\Model\Entity\SandboxArticle> $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\SandboxArticle> saveManyOrFail(iterable<\Sandbox\Model\Entity\SandboxArticle> $entities, array $options = [])
 * @method bool delete(\Sandbox\Model\Entity\SandboxArticle $entity, array $options = [])
 * @method bool deleteOrFail(\Sandbox\Model\Entity\SandboxArticle $entity, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\SandboxArticle>|false deleteMany(iterable<\Sandbox\Model\Entity\SandboxArticle> $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\Sandbox\Model\Entity\SandboxArticle> deleteManyOrFail(iterable<\Sandbox\Model\Entity\SandboxArticle> $entities, array $options = [])
 * @method \Sandbox\Model\Entity\SandboxArticle|array<\Sandbox\Model\Entity\SandboxArticle> loadInto(\Sandbox\Model\Entity\SandboxArticle|array<\Sandbox\Model\Entity\SandboxArticle> $entities, array $contain)
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \AuditStash\Model\Behavior\AuditLogBehavior
 */
class SandboxArticlesTable extends Table {

	/**
	 * Initialize method
	 *
	 * @param array<string, mixed> $config The configuration for the Table.
	 * @return void
	 */
	public function initialize(array $config): void {
		parent::initialize($config);

		$this->setTable('sandbox_articles');
		$this->setDisplayField('title');
		$this->setPrimaryKey('id');

		$this->addBehavior('Timestamp');
		$this->addBehavior('AuditStash.AuditLog', [
			'displayField' => 'title',
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
