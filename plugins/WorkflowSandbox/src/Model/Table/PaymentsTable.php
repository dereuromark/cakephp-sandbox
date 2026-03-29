<?php
declare(strict_types=1);

namespace WorkflowSandbox\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Payments Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @method \WorkflowSandbox\Model\Entity\Payment newEmptyEntity()
 * @method \WorkflowSandbox\Model\Entity\Payment newEntity(array $data, array $options = [])
 * @method array<\WorkflowSandbox\Model\Entity\Payment> newEntities(array $data, array $options = [])
 * @method \WorkflowSandbox\Model\Entity\Payment get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \WorkflowSandbox\Model\Entity\Payment findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \WorkflowSandbox\Model\Entity\Payment patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\WorkflowSandbox\Model\Entity\Payment> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \WorkflowSandbox\Model\Entity\Payment|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \WorkflowSandbox\Model\Entity\Payment saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \Workflow\Model\Behavior\WorkflowBehavior
 */
class PaymentsTable extends Table {

	/**
	 * @param array<string, mixed> $config
	 *
	 * @return void
	 */
	public function initialize(array $config): void {
		parent::initialize($config);

		$this->setTable('workflow_sandbox_payments');
		$this->setDisplayField('transaction_id');
		$this->setPrimaryKey('id');

		$this->addBehavior('Timestamp');
		$this->addBehavior('Workflow.Workflow', [
			'workflow' => 'payment',
			'autoSave' => true,
			'autoLog' => true,
		]);

		$this->belongsTo('Users', [
			'foreignKey' => 'user_id',
			'className' => 'Users',
		]);
	}

	/**
	 * @param \Cake\Validation\Validator $validator
	 *
	 * @return \Cake\Validation\Validator
	 */
	public function validationDefault(Validator $validator): Validator {
		$validator
			->scalar('transaction_id')
			->maxLength('transaction_id', 100)
			->allowEmptyString('transaction_id');

		$validator
			->decimal('amount')
			->requirePresence('amount', 'create')
			->notEmptyString('amount');

		$validator
			->scalar('currency')
			->maxLength('currency', 3)
			->allowEmptyString('currency');

		$validator
			->scalar('provider')
			->maxLength('provider', 50)
			->allowEmptyString('provider');

		return $validator;
	}

}
