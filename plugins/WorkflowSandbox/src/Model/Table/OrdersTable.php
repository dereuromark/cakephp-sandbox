<?php
declare(strict_types=1);

namespace WorkflowSandbox\Model\Table;

use Cake\Core\Configure;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Orders Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \WorkflowSandbox\Model\Entity\Order newEmptyEntity()
 * @method \WorkflowSandbox\Model\Entity\Order newEntity(array $data, array $options = [])
 * @method array<\WorkflowSandbox\Model\Entity\Order> newEntities(array $data, array $options = [])
 * @method \WorkflowSandbox\Model\Entity\Order get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \WorkflowSandbox\Model\Entity\Order findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \WorkflowSandbox\Model\Entity\Order patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\WorkflowSandbox\Model\Entity\Order> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \WorkflowSandbox\Model\Entity\Order|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \WorkflowSandbox\Model\Entity\Order saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\WorkflowSandbox\Model\Entity\Order>|\Cake\Datasource\ResultSetInterface<\WorkflowSandbox\Model\Entity\Order>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\WorkflowSandbox\Model\Entity\Order>|\Cake\Datasource\ResultSetInterface<\WorkflowSandbox\Model\Entity\Order> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\WorkflowSandbox\Model\Entity\Order>|\Cake\Datasource\ResultSetInterface<\WorkflowSandbox\Model\Entity\Order>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\WorkflowSandbox\Model\Entity\Order>|\Cake\Datasource\ResultSetInterface<\WorkflowSandbox\Model\Entity\Order> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \Workflow\Model\Behavior\WorkflowBehavior
 */
class OrdersTable extends Table {

	/**
	 * @param array<string, mixed> $config Configuration
	 * @return void
	 */
	public function initialize(array $config): void {
		parent::initialize($config);

		$this->setTable('workflow_orders');
		$this->setDisplayField('order_number');
		$this->setPrimaryKey('id');

		$this->addBehavior('Timestamp');
		$this->addBehavior('Workflow.Workflow', [
			'workflow' => 'order',
			'registry' => Configure::read('WorkflowSandbox.registry'),
			'autoSave' => true,
			'autoLog' => true,
		]);

		$this->belongsTo('Users', [
			'foreignKey' => 'user_id',
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
			->scalar('order_number')
			->maxLength('order_number', 50)
			->notEmptyString('order_number');

		$validator
			->scalar('status')
			->maxLength('status', 50)
			->notEmptyString('status');

		$validator
			->decimal('total')
			->notEmptyString('total');

		$validator
			->scalar('payment_method')
			->maxLength('payment_method', 50)
			->allowEmptyString('payment_method');

		$validator
			->scalar('shipping_address')
			->allowEmptyString('shipping_address');

		return $validator;
	}

	/**
	 * Generate unique order number
	 *
	 * @return string
	 */
	public function generateOrderNumber(): string {
		return 'ORD-' . date('Ymd') . '-' . strtoupper(substr(bin2hex(random_bytes(4)), 0, 8));
	}

}
