<?php
declare(strict_types=1);

namespace WorkflowSandbox\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Tickets Model
 *
 * @extends \Cake\ORM\Table<array{Timestamp: \Cake\ORM\Behavior\TimestampBehavior, Workflow: \Workflow\Model\Behavior\WorkflowBehavior}>
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Assignees
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @method \WorkflowSandbox\Model\Entity\Ticket newEmptyEntity()
 * @method \WorkflowSandbox\Model\Entity\Ticket newEntity(array $data, array $options = [])
 * @method array<\WorkflowSandbox\Model\Entity\Ticket> newEntities(array $data, array $options = [])
 * @method \WorkflowSandbox\Model\Entity\Ticket get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \Cake\ORM\Query\SelectQuery<\WorkflowSandbox\Model\Entity\Ticket> find(string $type = 'all', mixed ...$args)
 * @method \WorkflowSandbox\Model\Entity\Ticket findOrCreate(\Cake\ORM\Query\SelectQuery|callable|array $search, ?callable $callback = null, array $options = [])
 * @method \WorkflowSandbox\Model\Entity\Ticket patchEntity(\WorkflowSandbox\Model\Entity\Ticket $entity, array $data, array $options = [])
 * @method array<\WorkflowSandbox\Model\Entity\Ticket> patchEntities(iterable<\WorkflowSandbox\Model\Entity\Ticket> $entities, array $data, array $options = [])
 * @method \WorkflowSandbox\Model\Entity\Ticket|false save(\WorkflowSandbox\Model\Entity\Ticket $entity, array $options = [])
 * @method \WorkflowSandbox\Model\Entity\Ticket saveOrFail(\WorkflowSandbox\Model\Entity\Ticket $entity, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\WorkflowSandbox\Model\Entity\Ticket>|false saveMany(iterable<\WorkflowSandbox\Model\Entity\Ticket> $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\WorkflowSandbox\Model\Entity\Ticket> saveManyOrFail(iterable<\WorkflowSandbox\Model\Entity\Ticket> $entities, array $options = [])
 * @method bool delete(\WorkflowSandbox\Model\Entity\Ticket $entity, array $options = [])
 * @method bool deleteOrFail(\WorkflowSandbox\Model\Entity\Ticket $entity, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\WorkflowSandbox\Model\Entity\Ticket>|false deleteMany(iterable<\WorkflowSandbox\Model\Entity\Ticket> $entities, array $options = [])
 * @method \Cake\Datasource\ResultSetInterface<\WorkflowSandbox\Model\Entity\Ticket> deleteManyOrFail(iterable<\WorkflowSandbox\Model\Entity\Ticket> $entities, array $options = [])
 * @method \WorkflowSandbox\Model\Entity\Ticket|array<\WorkflowSandbox\Model\Entity\Ticket> loadInto(\WorkflowSandbox\Model\Entity\Ticket|array<\WorkflowSandbox\Model\Entity\Ticket> $entities, array $contain)
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \Workflow\Model\Behavior\WorkflowBehavior
 */
class TicketsTable extends Table {

	/**
	 * Priorities with labels
     * @var array
	 */
	public const PRIORITIES = [
		'low' => 'Low',
		'medium' => 'Medium',
		'high' => 'High',
		'urgent' => 'Urgent',
	];

	/**
	 * @param array<string, mixed> $config Configuration
	 * @return void
	 */
	public function initialize(array $config): void {
		parent::initialize($config);

		$this->setTable('workflow_tickets');
		$this->setDisplayField('subject');
		$this->setPrimaryKey('id');

		$this->addBehavior('Timestamp');
		$this->addBehavior('Workflow.Workflow', [
			'workflow' => 'ticket',
			'autoSave' => true,
			'autoLog' => true,
		]);

		$this->belongsTo('Users', [
			'foreignKey' => 'user_id',
			'className' => 'Users',
		]);

		$this->belongsTo('Assignees', [
			'foreignKey' => 'assignee_id',
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
			->integer('assignee_id')
			->allowEmptyString('assignee_id');

		$validator
			->scalar('ticket_number')
			->maxLength('ticket_number', 50)
			->notEmptyString('ticket_number');

		$validator
			->scalar('subject')
			->maxLength('subject', 255)
			->notEmptyString('subject');

		$validator
			->scalar('description')
			->allowEmptyString('description');

		$validator
			->scalar('priority')
			->maxLength('priority', 20)
			->inList('priority', array_keys(static::PRIORITIES))
			->notEmptyString('priority');

		$validator
			->scalar('status')
			->maxLength('status', 50)
			->notEmptyString('status');

		return $validator;
	}

	/**
	 * Generate unique ticket number
	 *
	 * @return string
	 */
	public function generateTicketNumber(): string {
		return 'TKT-' . date('Ymd') . '-' . strtoupper(substr(bin2hex(random_bytes(3)), 0, 6));
	}

}
