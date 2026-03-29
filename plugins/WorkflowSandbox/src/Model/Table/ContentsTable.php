<?php
declare(strict_types=1);

namespace WorkflowSandbox\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Contents Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Reviewers
 *
 * @method \WorkflowSandbox\Model\Entity\Content newEmptyEntity()
 * @method \WorkflowSandbox\Model\Entity\Content newEntity(array $data, array $options = [])
 * @method array<\WorkflowSandbox\Model\Entity\Content> newEntities(array $data, array $options = [])
 * @method \WorkflowSandbox\Model\Entity\Content get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \WorkflowSandbox\Model\Entity\Content findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \WorkflowSandbox\Model\Entity\Content patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\WorkflowSandbox\Model\Entity\Content> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \WorkflowSandbox\Model\Entity\Content|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \WorkflowSandbox\Model\Entity\Content saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\WorkflowSandbox\Model\Entity\Content>|\Cake\Datasource\ResultSetInterface<\WorkflowSandbox\Model\Entity\Content>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\WorkflowSandbox\Model\Entity\Content>|\Cake\Datasource\ResultSetInterface<\WorkflowSandbox\Model\Entity\Content> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\WorkflowSandbox\Model\Entity\Content>|\Cake\Datasource\ResultSetInterface<\WorkflowSandbox\Model\Entity\Content>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\WorkflowSandbox\Model\Entity\Content>|\Cake\Datasource\ResultSetInterface<\WorkflowSandbox\Model\Entity\Content> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \Workflow\Model\Behavior\WorkflowBehavior
 */
class ContentsTable extends Table {

	/**
	 * @param array<string, mixed> $config Configuration
	 * @return void
	 */
	public function initialize(array $config): void {
		parent::initialize($config);

		$this->setTable('workflow_contents');
		$this->setDisplayField('title');
		$this->setPrimaryKey('id');

		$this->addBehavior('Timestamp');
		$this->addBehavior('Workflow.Workflow', [
			'workflow' => 'content',
			'autoSave' => true,
			'autoLog' => true,
		]);

		$this->belongsTo('Users', [
			'foreignKey' => 'user_id',
			'className' => 'Users',
		]);

		$this->belongsTo('Reviewers', [
			'foreignKey' => 'reviewer_id',
			'className' => 'Users',
		]);
	}

	/**
	 * @param \Cake\Validation\Validator $validator Validator
	 * @return \Cake\Validation\Validator
	 */
	public function validationDefault(Validator $validator): Validator {
		$validator
			->integer('user_id')
			->allowEmptyString('user_id');

		$validator
			->integer('reviewer_id')
			->allowEmptyString('reviewer_id');

		$validator
			->scalar('title')
			->maxLength('title', 255)
			->notEmptyString('title');

		$validator
			->scalar('body')
			->allowEmptyString('body');

		$validator
			->scalar('status')
			->maxLength('status', 50)
			->notEmptyString('status');

		$validator
			->scalar('rejection_reason')
			->allowEmptyString('rejection_reason');

		return $validator;
	}

}
